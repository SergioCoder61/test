<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color_css код цвета css 
 * @property string $color_rus название цвета по-русски
 * @property int $emergence_time время создания
 * @property int $fall_time время падения
 * @property int $status_id статус
 * @property int $eating_percent съедено %
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_css', 'color_rus', 'emergence_time'], 'required'],
            [['emergence_time', 'fall_time', 'status_id', 'eating_percent'], 'integer'],
            [['color_css', 'color_rus'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_css' => 'css код цвета',
            'color_rus' => 'Цвет',
            'emergence_time' => 'Время создания',
            'fall_time' => 'Время падения',
            'status_id' => 'Статус',
            'eating_percent' => 'Съедено %',
        ];
    }

    /**
     * Выдача массива цветов яблок
     */
    public function appleColors()
    {
        return 
        [
            [
                'cssName' => 'Green',
                'rusName' => 'зеленый',
            ],
            [
                'cssName' => 'GreenYellow',
                'rusName' => 'желто-зеленый',
            ],
            [
                'cssName' => 'Yellow',
                'rusName' => 'желтый',
            ],
            [
                'cssName' => 'Orange',
                'rusName' => 'оранжевый',
            ],
            [
                'cssName' => 'Red',
                'rusName' => 'красный',
            ],
        ];
    }


    /**
     * Изменение статуса яблок, упавших с дерева (1) и пролежавших на земле более 5 часов
     * на статус гнилых яблок (3)
     */
    public function refreshStaus()
    {
        Yii::$app->db->createCommand('UPDATE apple SET status_id=3 WHERE status_id=1 AND :time - fall_time > 18000')
            ->bindValue(':time', time())
            ->execute();

        return true;
    }
}
