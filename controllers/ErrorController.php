<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2016/9/27
 * Time: 13:09
 */
namespace app\controllers;


use yii\web\Controller;

class ErrorController extends Controller
{
    public function actionError()
    {
        echo '程序员正在加班中';
    }
}