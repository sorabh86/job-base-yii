<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Category;
use app\models\Job;


class JobController extends Controller
{
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

        $job->delete();

        // Show message
        Yii::$app->getSession()->setFlash('success', 'Job Deleted');

        // redirect
        return $this->redirect(Yii::$app->homeUrl.'?r=job');
    }

    public function actionEdit($id)
    {
        $job = Job::findOne($id);

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
