<?php
/* @var $post \frontend\models\Post */
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <?php
        if($post->user){
            echo $post->user->username;
        }
        ?>
    </div>
    <div class="col-md-12">
        <img src="<?php echo $post->getImage($post->filename ); ?>" alt="post_photo">
    </div>
    <div class="col-md-12">
        <?php echo Html::encode($post->description); ?>
    </div>
</div>
