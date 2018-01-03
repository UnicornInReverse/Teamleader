<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Teamleader</h1>
    </div>
</div>

<button class="btn btn-success" onclick="history.back()">Terug</button><br><br>

<?php if ($message): ?>
    <h5><?= $message ?></h5>
<?php else: ?>
    <div>
        <h4><b>Totaal aantal uren: <?= $time?></b></h4>
    </div>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th>Item</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $items): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['employee_name'] ?><br>
                        <td><?= $item['company_name'] ?><br>
                            <?= $item['team'] ?><br>
                            <?= $item['description'] ?><br>
                            <?= $item['duration'] ?><br>
                            <?= $item['date_formatted'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
