<?php
/**
 * Created by PhpStorm.
 * User: TPN
 * Date: 12.01.2019
 * Time: 18:20
 */

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;

class TestController extends Controller
{
	public function actionIndex() {

		$product = new Product();
		$product -> id = 1;
		$product -> name = 'Nokia_6230';
		$product -> category = 'phone';
		$product -> price = 100;

		return $this->render('index', [
			'product' => $product
		]);
	}
}