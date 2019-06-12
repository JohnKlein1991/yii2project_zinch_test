<?php
/* @var $post \frontend\models\Post */
/* @var $this \yii\web\View */
/* @var $user  \frontend\models\User */
/* @var $comments \frontend\models\PostComments */
use yii\helpers\Html;
use yii\web\JqueryAsset;
use frontend\models\User;

$isLiked = $post->isLikedByUser($user);
$this->registerJsFile('@web/js/like.js', [
    'depends' => JqueryAsset::class
 ]);
?>
<div class="row">
    <div class="col-md-12">
        <?php
        if($post->user){
            ?>
            <h3><?=Html::encode($post->user->username)?></h3>
        <?php
        }
        ?>
    </div>
    <div class="col-md-6 text-center">
        <img class="img-thumbnail" src="<?php echo $post->getImage($post->filename ); ?>" alt="post_photo">
    </div>
    <div class="col-md-12">
        <p><?php echo Html::encode($post->description); ?></p>
    </div>
</div>
<div>
    <button type="button" class="yii2-project__like btn btn-success" data-post_id="<?=$post->id ?>"
        <?php if($isLiked){echo 'style="display: none"';}?>
    >
        Like <span class="likes_count"><?=$post->likesCount()?></span><span>&nbsp;&nbsp;&#128077;</span>
    </button>
    <button type="button" class="yii2-project__dislike  btn btn-danger" data-post_id="<?=$post->id ?>"
        <?php if(!$isLiked){echo 'style="display: none"';}?>
    >
        Unlike <span>&nbsp;&nbsp;&nbsp;&#128077;</span>
    </button>
</div>
<hr>
<div class="form-group purple-border">
    <label for="exampleFormControlTextarea4">Comment this</label>
    <textarea class="form-control yii2-project__textarea_comment" id="exampleFormControlTextarea4" data-post_id="<?=$post->id?>" rows="3"></textarea>
</div>
<button type="button" class="btn btn-info yii2-project__add_new_comment">
    Add new comment
</button>
<div>
    <h3>Comments</h3>
    <?php
    foreach ($comments as $comment) {
        ?>
        <div>
            <h4>Author: <?=User::findOne(['id' => $comment->user_id])->username?></h4>
            <p data-comment_id="<?=$comment->id?>"><?=$comment->content?></p>
            <?php
            if($user && $user->id === $comment->user_id){
                ?>
                <button type="button" class="btn btn-info yii2-project__edit_comment" data-comment_id="<?=$comment->id?>">
                    Edit
                </button>
            <?php
            }
            ?>
        </div>
        <hr>
    <?php
    }
    ?>
</div>
