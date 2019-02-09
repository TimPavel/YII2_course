<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use app\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        	TimestampBehavior::className(),
			[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'creator_id',
				'updatedByAttribute' => 'updater_id',
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
			// 'access' => [
			// 	'class' => AccessControl::className(),
			// 	'rules' => [
			// 		[
			// 			'allow' => true,
			// 			'roles' => ['@'],
			// 		],
			// 	],
			// ],
        ];
    }
    
    /**
     * for tests.
     * @return mixed
     */
    public function actionTest()
    {
    	return parent::className();
        // 4а
//        $model = new User();
//        $model->username = 'Dormidon';
//        $model->password_hash = 'ytytnnbnbnbytyty';
//        $model->creator_id = '3';
//        $model->created_at = time();
//        $model->save();
//
//        if(!$model->save()) {
//            VarDumper::dump($model->getErrors(), 5, true);
//        }
//
//        // 4б
//        $user = User::findOne(11);
//        $task = new Task();
//        $task->title = 'Forth title';
//        $task->description = 'Forth description';
//        $task->created_at = time();
//        $task->link('creator', $user);
//
//        if(!$task->save()) {
//            VarDumper::dump($task->getErrors(), 5, true);
//        }
//
//        // 4в
//        $users = User::find()
//            ->select(['username'])
//            ->with('tasks')
//            ->all();
//        VarDumper::dump($users, 5, true);
//
//
//        // 4г
//        $users = User::find()
//            ->joinWith('tasks')
//            ->all();
//        VarDumper::dump($users, 5, true);
//        exit();
        
        
//        $model = User::findOne(9);
//        VarDumper::dump(($model->getAccessedTasks()->all()), 5, true);
    }
    
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
