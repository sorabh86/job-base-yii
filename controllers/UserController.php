<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionRegister()
    {
        $user = new User();

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                // save users
            	$user->save();

            	// show message
            	Yii::$app->getSession()->setFlash('success','You are registered, Please login');

            	return $this->redirect(Yii::$app->homeUrl.'?r=site/login');
            }
        }

        return $this->render('register', [
            'user' => $user,
        ]);
    }

}
