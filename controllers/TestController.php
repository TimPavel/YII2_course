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
		return VarDumper::dumpAsString($model -> getAttributes());

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
}