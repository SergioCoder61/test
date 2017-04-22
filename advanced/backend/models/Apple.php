<?php

namespace app\models;

use Yii;

/**
 * Модель таблицы "apple".
 *
 * @property integer $id
 * @property integer $color_id
 * @property string $emergence_time
 * @property string $fall_time
 * @property integer $status_id
 * @property integer $eating_percent
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color_id', 'emergence_time', 'status_id', 'eating_percent'], 'required'],
            [['color_id', 'status_id', 'eating_percent'], 'integer'],
            [['emergence_time', 'fall_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_id' => 'Color ID',
            'emergence_time' => 'Emergence Time',
            'fall_time' => 'Fall Time',
            'status_id' => 'Status ID',
            'eating_percent' => 'Eating Percent',
        ];
    }

    /**
     * Изменение статуса яблок, упавших с дерева (2) и пролежавших на земле более 5 часов
     * на статус гнилых яблок (4)
     */
    public function refreshStaus()
    {
        $current_time = time();
        $command = Yii::$app->db->createCommand(
        'UPDATE apple SET status_id=4 ' .
        'WHERE status_id=2 AND (' . $current_time . '-fall_time) > 18000' );
        $command->execute();
        return true;
    }

    /**
     * Возвращает HTML-таблицу яблок, упавших с дерева ( status_id = 2 )
     */
    public function getFallenApples()
    {
        $fallenApples = Yii::$app->db->createCommand(
            'SELECT apple.id AS appleid, color_id, emergence_time, fall_time, eating_percent, ' . 
                'hex_code, name ' .
            'FROM apple, color ' .
            'WHERE status_id = 2 AND color.id = color_id ' .
            'ORDER BY fall_time')
            ->queryAll();
        $fallenApplesHtml = Yii::$app->view->renderFile('@backend/views/site/_fallen-apples.php', [
            'fallenApples' => $fallenApples,
            ]); 
        return $fallenApplesHtml;
    }

    /**
     * Возвращает HTML-таблицу яблок, висящих на дереве ( status_id = 1 )
     */
    public function getHangingApples()
    {
        $hangingApples = Yii::$app->db->createCommand(
            'SELECT apple.id AS appleid, color_id, emergence_time, ' . 
                'hex_code, name ' .
            'FROM apple, color ' .
            'WHERE status_id = 1 AND color.id = color_id ' .
            'ORDER BY emergence_time')
            ->queryAll();
        $hangingApplesHtml = Yii::$app->view->renderFile('@backend/views/site/_hanging-apples.php', [
            'hangingApples' => $hangingApples,
            ]); 
        return $hangingApplesHtml;
    }

    /**
     * Возвращает HTML-таблицу съеденных яблок ( status_id = 3 )
     */
    public function getEatenApples()
    {
        $eatenApples = Yii::$app->db->createCommand(
            'SELECT apple.id AS appleid, color_id, emergence_time, fall_time, eat_time, ' . 
                'hex_code, name ' .
            'FROM apple, color ' .
            'WHERE status_id = 3 AND color.id = color_id ' .
            'ORDER BY eat_time DESC')
            ->queryAll();
        $eatenApplesHtml = Yii::$app->view->renderFile('@backend/views/site/_eaten-apples.php', [
            'eatenApples' => $eatenApples,
            ]); 
        return $eatenApplesHtml;
    }

}
