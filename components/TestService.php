<?php
/**
 * Created by PhpStorm.
 * User: TPN
 * Date: 16.01.2019
 * Time: 22:48
 */

namespace app\components;

use yii\base\Component;

class TestService extends Component
{
	public $prop = 'simple text';

	public function show() {
		return $this -> prop;
	}
}