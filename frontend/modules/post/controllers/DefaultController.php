<?php

namespace frontend\modules\post\controllers;

use yii\web\Controller;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public function actionCreate()
    {
        return $this->render('create');
    }
}
