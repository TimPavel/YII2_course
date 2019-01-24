<?php
/**
 * Created by PhpStorm.
 * User: TPN
 * Date: 12.01.2019
 * Time: 18:20
 */

namespace app\controllers;

use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\Product;
use Yii;

class TestController extends Controller
{
	public function actionIndex() {

		$model = new Product();
		$model -> id = 1;
		$model -> name = "<p>Nokia_6230 </p> ";
		//$model -> category = 'phone';
		$model -> price = 120;
		$model -> created_at = 120;

		$model->validate();
		//return VarDumper::dumpAsString($product -> safeAttributes());
		//return VarDumper::dumpAsString($model -> getAttributes());

		return $this->render('index', [
			'product' => $model
		]);
	}

	public function actionShow() {

		$var = Yii::$app -> test -> show();
		return $this->render('show', [
			'var' => $var
		]);
	}
	
	public function actionInsert() {
//        3) В экшене insert TestController-а через Yii::$app->db->createCommand()->insert()
//        вставить несколько записей в таблицу user,
//        в поле password_hash можно вставить произвольные значения, поле id заполняется автоматически.
        Yii::$app->db->createCommand()->insert('user', [
            'username' => 'third',
            'password_hash' => 'fdgdukiiofgfg56565fgf',
            'creator_id' => time(),
            'created_at' => time(),
        ])->execute();
        
//        5) В экшене insert TestController-а через Yii::$app->db->createCommand()->batchInsert()
//        вставить одним вызовом сразу 3 записи в таблицу task, в поле creator_id подставив
//        реальное значение id из user (просто числом).
        Yii::$app->db->createCommand()->batchInsert('task',
            ['title', 'description', 'creator_id', 'created_at'], [
            ['first_title', 'first_description', 1, time()],
            ['second_title', 'second_description', 2, time()],
            ['third_title', 'third_description', 5, time()],
        ])->execute();
        
    }
    
    public function actionSelect() {
//       4) Используя \yii\db\Query в экшене select TestController выбрать из user:
//       а) Запись с id=1
        $result = (new \yii\db\Query())
            ->from('user')
            ->where('id=:id', [':id' => 1])
            ->one();

//       б) Все записи с id>1 отсортированные по имени (orderBy())
        $result = (new \yii\db\Query())
            ->from('user')
            ->where(['>', 'id', 1])
            ->orderBy('username ASC')
            ->all();
    
//        в) количество записей.
        $result = count($result);

        return VarDumper::dumpAsString($result, 3, true);
    }
}