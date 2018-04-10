<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
// use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Category;

class CategoryController extends Controller {

	/**
     *   Access Control
    **/
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                	[
	                    'actions' => ['create'],
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
    	$query = Category::find();

    	$pagination = new Pagination([
    		'defaultPageSize' => 20,
    		'totalCount' => $query->count()
    	]);

    	$categories = $query->orderBy('name')
    		->offset($pagination->offset)
    		->limit($pagination->limit)
    		->all();

        return $this->render('index', [
        	'categories' => $categories, 
        	'pagination' => $pagination
        ]);
    }

    public function actionCreate()
	{
	    $category = new Category();

	    if ($category->load(Yii::$app->request->post())) {
	        // validation
	        if ($category->validate()) {
	        	//save record
	        	$category->save();

	        	// send message
	        	Yii::$app->getSession()->setFlash('success', 'New Category Added');

	            // redirect
	            return $this->redirect(Yii::$app->homeUrl.'?r=category');
	        }
	    }

	    return $this->render('create', [
	        'category' => $category,
	    ]);
	}

}
