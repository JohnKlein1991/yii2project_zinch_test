<?php
/* @var $user \frontend\models\User */
/* @var $currentUser \frontend\models\User */
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;
use frontend\models\User;

echo Html::tag('h4', 'Hello! It\'s the page of ' . Html::encode($user->nickname));
echo Html::tag('p', Html::encode('Name: ' . $user->username));
echo Html::tag('p', HtmlPurifier::process('About: ' . $user->about));
?>
<hr>
<div class="">

<!-- Button trigger followers modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#followersModal">
    Show followers(<?=$user->countOfFollowers()?>)
</button>

<!-- Button trigger subscribers modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#subscribersModal">
    Show subscriptions(<?=$user->countOfSubscribers()?>)
</button>

<!-- Followers modal -->
<div class="modal fade" id="followersModal" tabindex="-1" role="dialog" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followersModalLabel">Followers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Subscribers modal -->
<div class="modal fade" id="subscribersModal" tabindex="-1" role="dialog" aria-labelledby="subscribersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscribersModalLabel">Followers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
<hr>
Friends, who also follow this person:
<?php
foreach ($user->getCommonFollowers($currentUser) as $person) {
?>
    <a href="<?=Url::toRoute([
            '/user/profile/view', 'nickname' => $person['nickname'] ? $person['nickname'] : $person['id']
    ])?>" class="btn btn-info"><?=$person['username']?></a>
<?php
}
?>
<hr>
<div class="">
    <a href="<?=Url::toRoute(['/user/profile/subscribe', 'id' => $user->getId()])?>" class="btn btn-info">Subscribe</a>
    <a href="<?=Url::toRoute(['/user/profile/unsubscribe', 'id' => $user->getId()])?>" class="btn btn-info">Unsubscribe</a>
</div>
<hr>
<div>
    <a href="<?=Url::home()?>" class="btn btn-primary btn-lg">Go back</a>
</div>