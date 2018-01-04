<?php
echo $this->Html->css('Teamleader.select2.css');
echo $this->Html->css('Teamleader.datatables.min.css');
echo $this->Html->css('Teamleader.datepicker.css');
?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Teamleader</h1>
        </div>
    </div>

    <form class="form-horizontal" method="post">
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label" for="company">Company:</label>
                <div class="col-md-5">
                    <select class="js-data-example-ajax form-control input-md" name="company" id="company" required>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="date_from">Datum vanaf:</label>
                <div class="col-md-5">
                    <input id="date_from" name="date_from" type="text" value="04/12/2016"
                           class="datepicker-here form-control input-md" data-language="nl" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="date_to">Datum tot:</label>
                <div class="col-md-5">
                    <input id="date_to" name="date_to" type="text" value="04/12/2017"
                           class="datepicker-here form-control input-md" data-language="nl" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="issue">Issue:</label>
                <div class="col-md-5">
                    <input id="issue" name="issue" type="text" value="#8209" class="form-control input-md" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-4">
                    <button id="submit" name="submit" value="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </fieldset>
    </form>

<?php
echo $this->Html->script('Teamleader.datepicker.js', ['block' => 'script']);
echo $this->Html->script('Teamleader.select2.full.js', ['block' => 'script']);
echo $this->Html->script('Teamleader.datepicker.nl.js', ['block' => 'script']);
echo $this->Html->script('Teamleader.nl.js', ['block' => 'script']);

echo $this->Html->script('Teamleader.teamleader.js', ['block' => 'script']);


