<h3>Гнилые яблоки</h3>

<table class="table table-striped table-bordered">
<thead>
<tr>
<th>№ п/п</th>
<th>Код</th>
<th>Цвет</th>
<th>% съеденного</th>
<th>Время создания</th>
<th>Время, когда упало</th>
<th>Время, когда сгнило</th>
<th>Удалить</th>
</tr>
</thead> 
<tbody>

<?php 
if (empty($rottenApples)) {
?>	
<tr>
<td colspan="8">ничего не найдено</td>
</tr>
<?php 
} else {
$i = 0;
foreach ($rottenApples as $apple) {
$i++;
$emergence_time = date("d.m.Y H:i", $apple['emergence_time'] );
$rott_stamp = $apple['fall_time'] + 18000;
$fall_time = date("d.m.Y H:i", $apple['fall_time'] );
$rott_time = date("d.m.Y H:i", $rott_stamp );
?>	
<tr>
<td><?= $i ?></td>
<td><?= $apple['appleid'] ?></td>
<td>
	<div class="color-block" style="background-color: #<?= $apple['hex_code'] ?>"></div>
	<?= $apple['name'] ?>
</td>
<td><?= $apple['eating_percent'] ?></td>
<td><?= $emergence_time ?></td>
<td><?= $fall_time ?></td>
<td><?= $rott_time ?></td>

<td>
<form id="w0" class="form-inline" action="/advanced/backend/web/index.php?r=site/delete" method="post">
	<input type="hidden" name="_csrf" value="R1lFbjZFMHMzPREiWg9qPgYUfV5nM2U2cxUXLEcdeRt0OjEAb3R4Pg==">
	<input type="hidden" name="id" value="<?= $apple['appleid'] ?>">
	<button type="submit" class="btn btn-danger btn-sm left-margin">удалить</button>
</form> 	
</td>
</tr>
<?php  
}
}
?>	

</tbody>
</table>