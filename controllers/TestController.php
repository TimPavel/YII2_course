<?php
/**
 * Created by PhpStorm.
 * User: TPN
 * Date: 12.01.2019
 * Time: 18:20
 */

namespace app\controllers;


use phpDocumentor\Reflection\Types\Object_;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;

class TestController extends Controller
{
	public function actionIndex() {

		$model = new Object_();
		$model -> id = 1;
		$model -> name = "<p>Nokia_6230 </p> ";
		//$model -> category = 'phone';
		$model -> price = 3599;
		$model -> created_at = 120;

//		$model->validate();
		//return VarDumper::dumpAsString($product -> safeAttributes());
		//return VarDumper::dumpAsString($model -> getAttributes());

		return \Yii::t(
    'app',
    'На диване {n, plural, =0{нет кошек} =1{лежит одна кошка} one{лежит # кошка} few{лежит # кошки} many{лежит # кошек} other{лежит # кошки}}!', 
    ['n' => 27]
);
		// VarDumper::dump(\Yii::$aliases, 5, true);
		// return $this->render('index', [
		// 	'product' => $model
		// ]);
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
            'username' => 'fifth',
            'password_hash' => 'fpppppppy',
            'creator_id' => 15,
            'created_at' => time(),
        ])->execute();
        
//        5) В экшене insert TestController-а через Yii::$app->db->createCommand()->batchInsert()
//        вставить одним вызовом сразу 3 записи в таблицу task, в поле creator_id подставив
////        реальное значение id из user (просто числом).
//        Yii::$app->db->createCommand()->batchInsert('task',
//            ['title', 'description', 'creator_id', 'created_at'], [
//            ['first_title', 'first_description', 1, time()],
//            ['second_title', 'second_description', 2, time()],
//            ['third_title', 'third_description', 5, time()],
//        ])->execute();
//
    }
    
    public function actionSelect() {
//       4) Используя \yii\db\Query в экшене select TestController выбрать из user:
//       а) Запись с id=1
        $result = (new \yii\db\Query())
            ->from('user')

            ->where('id=:id', [':id' => 3])
            ->one();
    
        return VarDumper::dumpAsString($result, 3, true);
       

//
//////       б) Все записи с id>1 отсортированные по имени (orderBy())
//        $result = (new \yii\db\Query())
//            ->from('user')
//            ->where(['>', 'id', 1])
//            ->orderBy('username ASC')
//            ->all();
//
//         return VarDumper::dumpAsString($result, 3, true);
////
////
////        в) количество записей.
//         $result = (new \yii\db\Query())
//            ->from('user')
//            ->where(['>', 'id', 1])
//            ->orderBy('username ASC')
//            ->count();
//
//        return VarDumper::dumpAsString($result, 3, true);
//
        
//        $result = (new \yii\db\Query())
//            ->from('task')
//            ->innerJoin('user', 'task.creator_id = user.id')

//            ->all();
//        return VarDumper::dumpAsString($result, 2, true);
//
    }
}