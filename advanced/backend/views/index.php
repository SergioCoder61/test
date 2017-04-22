<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

<form id="w0" class="form-vertical" action="/advanced/backend/web/index.php?r=site/create" method="post">
	<input type="hidden" name="_csrf" value="R1lFbjZFMHMzPREiWg9qPgYUfV5nM2U2cxUXLEcdeRt0OjEAb3R4Pg==">
<span class="form-text">Создать </span>
	<select class="form-control number-input" name="amount" id="amount">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>    
        <option value="4">4</option>
        <option value="5">5</option>    
	</select>
<span class="form-text"> шт. яблок </span>
        <button type="submit" class="btn btn-success left-margin">СОЗДАТЬ</button>
    </form>

<?= $fallenApples ?>

<?= $hangingApples ?>

<?= $eatenApples ?>

</div>
