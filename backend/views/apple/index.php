<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Яблоки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать яблоки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn', 
                'contentOptions' => ['style' => 'width:8%;'],            
            ],

            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width:8%;'],
            ],

            [
                'attribute' => 'color_rus',
                'contentOptions' => ['style' => 'width:15%;'],
                'filter' => ['зеленый' => 'зеленый', 'желто-зеленый' => 'желто-зеленый', 'желтый' => 'желтый', 'оранжевый' => 'оранжевый', 'красный' => 'красный'], //$data->color_rus,
                'format' => 'raw',
                'value' => function($data) {
                    return Html::tag('div', '', ['style' => 'display:inline-block;margin-right:5px;width:10px; height:10px; background-color:' . $data->color_css . '; border-radius:6px;'] ) . $data->color_rus; 
                }
            ],

            [
                'attribute' => 'emergence_time',
                'contentOptions' => ['style' => 'width:16%;'],
                'filter' =>  false,
                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
            ],

            [
                'attribute' => 'fall_time',
                'contentOptions' => ['style' => 'width:16%;'],
                'filter' =>  false,
                'value' => function($data) {
                    if ($data->fall_time == 0) {
                        return 0; 
                    } else {
                        return date("d.m.Y H:i:s", $data->fall_time);                         
                    }
                }
            ],

            [
                'attribute' => 'status_id',
                'contentOptions' => ['style' => 'width:16%;font-weight:bold'],
                'filter' => [0 => 'на дереве', 1 => 'упало', 2 => 'съедено все', 3 => 'гнилое'],
                'value' => function($data) {
                    switch ($data->status_id) {
                        case 0:
                            return 'на дереве';
                            break;
                        case 1:
                            return 'упало';
                            break;
                        case 2:
                            return 'съедено все';
                            break;
                        case 3:
                            return 'гнилое';
                            break;
                    }
                }
            ],

            [
                'attribute' => 'eating_percent',
                'contentOptions' => ['style' => 'width:15%;'],
                'filter' => [0 => 0, 25 => 25, 50 => 50, 75 => 75, 100 => 100],
            ],

            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{fall} {eat} {delete}',
                'buttons' => [
                    'fall' => function($url, $data, $key) {
                        if ($data->status_id == 0) {
                            return Html::a('<span class="glyphicon glyphicon-circle-arrow-down"></span>', 
                            ['fall', 'id' => $key], 
                            ['style' => 'font-size:20px;', 'title' => 'упасть']);
                        } else {
                            return '';
                        }
                    },
                    'eat' => function($url, $data, $key) {
                        if ($data->status_id == 1) {
                            return Html::a('<span class="glyphicon glyphicon-minus-sign"></span>', 
                            ['eat', 'id' => $key], 
                            ['style' => 'font-size:20px;', 'title' => 'есть']);
                        } else {
                            return '';                        
                        }
                    },
        
                    'delete' => function ($url, $data, $key) {
                        if ($data->status_id > 1) {
                            return Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'style' => 'font-size:20px;color:red',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0']);
                        } else {
                            return '';                        
                        }
                    },                     
             
                ],
            ],
        ],
    ]); ?>


</div>
