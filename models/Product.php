<?php

namespace app\models;

use Yii;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $created_at
 */
class Product extends \yii\db\ActiveRecord
{
	CONST SCENARIO_UPDATE = 'update';
	CONST SCENARIO_CREATE = 'create';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function scenarios()
	{
		return [
			self::SCENARIO_UPDATE => ['price', 'created_at'],
			self::SCENARIO_CREATE => ['name', 'price', 'created_at'],
		];
	}

	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'created_at'], 'required', 'on' => self::SCENARIO_CREATE], // обяз атрибуты при создании
            [['price', 'created_at'], 'required', 'on' => self::SCENARIO_UPDATE],	// обяз атрибуты при обновлении данных
            [['created_at'], 'integer'],
            [['price'], 'integer', 'min' => 0, 'max' => 1000],
            [['name'], 'string', 'max' => 20],
            [['name'], 'trim'],
            [['name'], 'filter', 'filter' => function($value) {
        		$value = strip_tags($value);	// удаляем HTML тэги
        		return $value;
			}],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }
}
