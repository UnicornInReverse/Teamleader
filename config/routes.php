<?php
use Cake\Routing\Router;

Router::plugin(
    'Teamleader',
    ['path' => '/teamleader'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
