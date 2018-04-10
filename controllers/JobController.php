<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\models\Category;
use app\models\Job;


class JobController extends Controller
{
    /**
     *   Access Control
    **/
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'edit', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        // create query
        $query = Job::find();

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count()
        ]);

        $jobs = $query->orderBy('create_date DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'jobs' => $jobs, 
            'pagination' => $pagination
        ]);
    }

    public function actionDetails($id)
    {
        $job = Job::find()
            ->where(['id'=>$id])
            ->one();

        // Reder view
        return $this->render('details', [
            'job' => $job
        ]);
    }

    public function actionCreate()
    {
        $job = new Job();

        if ($job->load(Yii::$app->request->post())) {
            if ($job->validate()) {
                // Save
                $job->save();

                // send message
                Yii::$app->getSession()->setFlash('success', 'New Job Added');

                return $this->redirect(Yii::$app->homeUrl.'?r=job');
            }
        }

        return $this->render('create', [
            'job' => $job
        ]);
    }

    public function actionDelete($id)
    {
        $job = Job::findOne($id);

        // Check for owner by comparing with current login id to user id
        if(Yii::$app->user->identity->id != $job->user_id) {
            // Redirect
            return $this->redirect(Yii::$app->homeUrl.'?r=job');            
        }
        
        $job->delete();

        // Show message
        Yii::$app->getSession()->setFlash('success', 'Job Deleted');

        // redirect
        return $this->redirect(Yii::$app->homeUrl.'?r=job');
    }

    public function actionEdit($id)
    {
        $job = Job::findOne($id);

        // Check for owner by comparing with current login id to user id
        if(Yii::$app->user->identity->id != $job->user_id) {
            // Redirect
            return $this->redirect(Yii::$app->homeUrl.'?r=job');            
        }

        if ($job->load(Yii::$app->request->post())) {
            if ($job->validate()) {
                // Save
                $job->save();

                // send message
                Yii::$app->getSession()->setFlash('success', 'New Job Updated');

                return $this->redirect(Yii::$app->homeUrl.'?r=job');
            }
        }

        return $this->render('edit', [
            'job' => $job
        ]);
    }

}
