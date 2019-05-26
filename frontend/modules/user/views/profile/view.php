<?php
/* @var $user \frontend\models\User */
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;
use frontend\models\User;

echo Html::tag('h4', 'Hello! It\'s the page of ' . Html::encode($user->nickname));
echo Html::tag('p', Html::encode('Name: ' . $user->username));
echo Html::tag('p', HtmlPurifier::process('About: ' . $user->about));
?>
<div class="col-lg">
    <h4>Followers</h4>
    <p><?php
        $followers = $user->getFollowers();
        foreach ($followers as $follower){
            echo '<a href="'.Url::toRoute([
                    '/user/profile/view',
                    'nickname' => $follower['nickname'] ? $follower['nickname'] : $follower['id']
                ]).'">
                    '.$follower['username'].' '.$follower['nickname'].'
                </a>';
        }
        ?></p>
</div>
<div class="col-lg">
    <h4>Subscribers</h4>
    <p><?php
        $subscribers = $user->getSubscribers();
        foreach ($subscribers as $subscriber){
            echo '<a href="'.Url::toRoute([
                    '/user/profile/view',
                    'nickname' => $subscriber['nickname'] ? $subscriber['nickname'] : $subscriber['id']
                ]).'">
                    '.$subscriber['username'].' '.$subscriber['nickname'].'
                </a>';
        }
        ?></p>
</div>
<?php
echo Html::tag(
    'a',
    'Subscribe',
    ['href' => Url::toRoute(['/user/profile/subscribe', 'id' => $user->getId()]), 'class' => 'btn btn-info']);
echo Html::tag(
    'a',
    'Unsubscribe',
    ['href' => Url::toRoute(['/user/profile/unsubscribe', 'id' => $user->getId()]), 'class' => 'btn btn-info']);

echo Html::tag(
    'a',
    'Go back',
    ['href' => Url::home(), 'class' => 'btn btn-primary btn-lg']
);