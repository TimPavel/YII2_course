<?php
/**
 * Created by PhpStorm.
 * User: TPN
 * Date: 12.01.2019
 * Time: 18:20
 */

namespace app\controllers;

use yii\web\Controller;


class TestController extends Controller
{
	public function actionIndex() {
        return $this->render('index');

	}

	public function actionShow() {
        echo "Hello! This testController' show page";

	}

}