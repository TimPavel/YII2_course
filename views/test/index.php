<?php
/**
 * TestController's view.
 * @var $product \app\models\Product
 * @param DetailView yii\widgets\DetailView
 */

use yii\widgets\DetailView;
?>

<h1><?='Hello!'?></h1>

<?= DetailView::widget([
	'model' => $product,
	'attributes' => [
		'id',
		'name',
		'price',
		'created_at',
	],
]);
?>




