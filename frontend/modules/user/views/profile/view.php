<?php
/* @var $user \frontend\models\User */

use yii\helpers\Html;

echo Html::tag('p', 'name: '.$user->username);
echo Html::tag('p', 'id: '.$user->id);
