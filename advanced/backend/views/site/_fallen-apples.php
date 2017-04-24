<h3>Упали с дерева (можно съесть)</h3>

<table class="table table-striped table-bordered">
<thead>
<tr>
<th>№ п/п</th>
<th>Код</th>
<th>Цвет</th>
<th>% съеденого</th>
<th>Сколько минут будет съедобным</th>
<th>Съесть %</th>
</tr>
</thead> 
<tbody>

<?php 
if (empty($fallenApples)) {
?>	
<tr>
<td colspan="6">ничего не найдено</td>
</tr>
<?php 
} else {
$current_time = time();
$i = 0;
foreach ($fallenApples as $apple) {
$i++;
$minutes = floor((18000 - ($current_time - $apple['fall_time']))/60);
?>	
<tr>
<td><?= $i ?></td>
<td><?= $apple['appleid'] ?></td>
<td>
	<div class="color-block" style="background-color: #<?= $apple['hex_code'] ?>"></div>
	<?= $apple['name'] ?>
</td>
<td><?= $apple['eating_percent'] ?></td>
<td><?= $minutes ?></td>
<td>
<form id="w0" class="form-inline" action="/advanced/backend/web/index.php?r=site/eat" method="post">
	<input type="hidden" name="_csrf" value="R1lFbjZFMHMzPREiWg9qPgYUfV5nM2U2cxUXLEcdeRt0OjEAb3R4Pg==">
	<input type="hidden" name="id" value="<?= $apple['appleid'] ?>">
	<select class="form-control number-small-input" name="eat" id="eat">
<?php  
for ($e = $apple['eating_percent'] + 25; $e <= 100; $e = $e + 25) {
?>		
		<option value="<?= $e ?>"><?= $e ?></option>
<?php  
    }
?>	
	</select>
%
	<button type="submit" class="btn btn-primary btn-sm left-margin">съесть</button>
    </form> 
</td>
</tr>
<?php  
}
}
?>	
</tbody>
</table>