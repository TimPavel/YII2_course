<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use Yii;
use yii\db\ActiveQuery;
use app\models\TaskUser;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
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
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
        ];
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
     * Unshared.
     * If creation is successful, the browser will be redirected to the 'task/shared' page.
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
     * Delete all accesses for a task.
     * If deletion is successful, the browser will be redirected to the 'task/shared' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException
     */
    public function actionDeleteAll($taskId)
    {
        
        $accessedTasks = TaskUser::findAll(['task_id' => $taskId]);
        $task = TASK::findOne($taskId);
     
        foreach ($accessedTasks as $task_user) {
           
            if (!$task_user || $task->creator_id != Yii::$app->user->id) {
                throw new ForbiddenHttpException();
            }
            $task->unlinkAll('taskUsers', true);
        }
        
       Yii::$app->session->setFlash('success', 'Доступы к задаче удалены');
       return $this->redirect(['task/shared']);
    }


    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'task/shared' page.
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

    protected function findModel($id)
    {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
