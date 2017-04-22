<h3>Висят на дереве (упадут - можно будет съесть)</h3>

<table class="table table-striped table-bordered">
<thead>
<tr>
<th>№ п/п</th>
<th>Код</th>
<th>Цвет</th>
<th>Время создания</th>
<th class="action-column">&nbsp;</th>
</tr>
</thead> 
<tbody>

<?php 
if (empty($hangingApples)) {
?>	
<tr>
<td colspan="5">ничего не найдено</td>
</tr>
<?php 
} else {
$i = 0;
foreach ($hangingApples as $apple) {
$i++;
$emergence_time = date("d.m.Y H:i", $apple['emergence_time'] );
?>	
<tr>
<td><?= $i ?></td>
<td><?= $apple['appleid'] ?></td>
<td>
	<div class="color-block" style="background-color: #<?= $apple['hex_code'] ?>"></div>
	<?= $apple['name'] ?>
</td>
<td><?= $emergence_time ?></td>
<td>
<form id="w0" class="form-inline" action="/advanced/backend/web/index.php?r=site/fall" method="post">
	<input type="hidden" name="_csrf" value="R1lFbjZFMHMzPREiWg9qPgYUfV5nM2U2cxUXLEcdeRt0OjEAb3R4Pg==">
	<input type="hidden" name="id" value="<?= $apple['appleid'] ?>">
	<button type="submit" class="btn btn-success btn-sm left-margin">упасть</button>
</form> 	
</td>
</tr>
<?php  
}
}
?>	

</tbody>
</table>