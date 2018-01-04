<?php
/**
 * Created by PhpStorm.
 * User: maaik
 * Date: 29/12/2017
 * Time: 11:40
 */

namespace Teamleader\Controller;

use Cake\Http\Client;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Cake\Core\Configure;


class TeamleaderController extends AppController
{

    public function getTimetracking()
    {
        if ($this->request->is('post')) {
            foreach ($this->request->data as $field => $data) {
                var_dump($field, $data);
            }

            $date_from = DateTime::createFromFormat('d/m/Y', $this->request->data('date_from'));
            $date_to = DateTime::createFromFormat('d/m/Y', $this->request->data('date_to'));

            $diff = $date_from->diff($date_to);
            $d = $diff->format('%r%a');
            $difference = (int)$d;

            if ($difference > 365) {
                $this->setAction('display', null, null, 'Periode mag niet langer dan een jaar zijn');
            } else if ($difference > 30) {
                $this->setAction('multirequest', $this->request->data);
            } else if ($difference < 0) {
                $this->setAction('display', null, null, 'Eind datum moet langer zijn dan begin datum');
            } else {
                $this->setAction('searchIssue', $this->request->data('issue'), [$this->singleRequest($date_from, $date_to)]);
            }

        }

    }

    public function display($result, $time, $message)
    {
        $this->set('result', $result);
        $this->set('time', $time);
        $this->set('message', $message);
    }

    public function singleRequest($date_from, $date_to)
    {
        $http = new Client();
        $response = $http->post('https://app.teamleader.eu/api/getTimetracking.php',
            [
                'date_from' => $date_from->format('d/m/Y'),
                'date_to' => $date_to->format('d/m/Y'),
                'company_id' => $this->request->data('company'),
                'api_secret' => 'tOObNQn8zzU35allrmX1HLMBtagrXeGgSlhv1vurVekQfw2xJPohr1JK2P2PUzVCK3YBpiSbn3StqKQZp57GWGhOmau6zfy99mBpvkqId81tJIjYEgvrNC5ZDpV2vj2vwuKRE1qH0h1zQbokhJBUcxJFNvy9Frv1L6JfXZNO7EeOFsYN1qy4O8zstYsYgNPRJpXxeAcc',
                'api_group' => 19153
            ]);

        if ($response->getStatusCode() != 200) {
            $res = $response->json;
            $message = $res['reason'];
            $this->setAction('display', null, null, $message);
            return null;
        }

        $items = $response->json;
        return $items;
    }

    public function getCompany()
    {
        $this->autoRender = false;
        $this->response->type('json');
        $http = new Client();
        $response = $http->post('https://app.teamleader.eu/api/getCompanies.php',
            [
                'amount' => 10,
                'pageno' => 0,
                'searchby' => $this->request->data('searchby'),
                'api_secret' => Configure::read('Teamleader.api_secret'),
                'api_group' => Configure::read('Teamleader.api_group'),
            ]);

        if ($response->getStatusCode() != 200) {
            $res = $response->json;
            $message = $res['reason'];
            $this->setAction('display', null, null, $message);
            return null;
        }

        $items = json_encode($response->json);
        $this->response->body($items);
        return $this->response;
    }

    public function multiRequest($data)
    {
        $items = [];

        $date_from = DateTimeImmutable::createFromFormat('d/m/Y', $data['date_from']);
        $date_to = $date_from->add(new DateInterval('P30D'));

        $date_to_def = DateTimeImmutable::createFromFormat('d/m/Y', $data['date_to']);
        $diff = $date_from->diff($date_to_def);
        $d = $diff->format('%a');
        $difference = (int)$d;

        while ($difference > 29) {
            $req = $this->singleRequest($date_from, $date_to);
            array_push($items, $req);

            $date_from = $date_to->add(new DateInterval('P1D'));
            $date_to = $date_from->add(new DateInterval('P30D'));

            $difference -= 30;

            if ($difference < 36) {
                $req = $this->singleRequest($date_from, $date_to_def);
                array_push($items, $req);
                break;
            }
        }
        $this->setAction('searchIssue', $this->request->data('issue'), $items);
    }

    function searchIssue($issue, $array)
    {
        $result = [];
        $time = 0;
        foreach ($array as $items) {
            foreach ($items as $item) {
                $search = strpos($item['description'], $issue);

                if ($search === false) {

                } else {
                    $time += $item['duration'];
                    array_push($result, $item);
                }
            }
        }

        $time = $time / 60;
        $this->setAction('display', [$result], $time, null);
    }
}
