<?php

namespace app\modules\portal\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
	    $this->layout = 'main';
        return $this->render('index');
    }
}
