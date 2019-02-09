<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use yii\db\ActiveQuery;
use app\models\TaskUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
     * Lists all TaskUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TaskUser::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskUser model.
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
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'task/my' page.
     * @return mixed
     */
    public function actionCreate($taskId)
    {
    	$task = Task::findOne($taskId);
    	if(!$task || $task->creator_id != Yii::$app->user->id) {
			throw new ForbiddenHttpException();
		}
        $model = new TaskUser();
        $model->task_id = $taskId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->session->setFlash('success', 'Успешно');
            return $this->redirect(['task/shared']);
        }

        $users = User::find()
			->where(['<>', 'id', Yii::$app->user->id])
			->select('username')
			->indexBy('id')
			->column();

        Yii::$app->session->setFlash('success', 'Успешно создано');        
        return $this->render('create', [
            'users' => $users,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TaskUser model.
     * If creation is successful, the browser will be redirected to the 'task/my' page.
     * @return mixed
     */
    public function actionUnshareAll($taskId)
    {
        $task = Task::findOne($taskId);
        if(!$task || $task->creator_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }
        $task->unlinkAll(Task::RELATION_TASK_USERS, true);
        
        Yii::$app->session->setFlash('success', 'Успешно удалено');
        return $this->redirect(['task/shared']);
    }

    /**
     * Updates an existing TaskUser model.
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

        Yii::$app->session->setFlash('success', 'Успешно обновлено');    
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено');    
        return $this->redirect(['task/shared']);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteAll($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Успешно удалено');    
        return $this->redirect(['task/shared']);

        

         $task = Task::findOne($taskId);
        if(!$task || $task->creator_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }
        $task->unlinkAll(Task::RELATION_TASK_USERS, true);
        
        Yii::$app->session->setFlash('success', 'Успешно удалено');
        return $this->redirect(['task/shared']);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
