<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }
    public function getImage($name)
    {
        return Yii::$app->storage->getFile($name);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), [
            'id' => 'user_id'
        ]);
    }
    public function like($user)
    {
        $redis = Yii::$app->redis;
        $redis->sadd('post:'.$this->id.':like', $user->id);
        $redis->sadd('user:'.$user->id.':like', $this->id);
        return $this->likesCount();
    }
    public function dislike($user)
    {
        $redis = Yii::$app->redis;
        $redis->srem('post:'.$this->id.':like', $user->id);
        $redis->srem('user:'.$user->id.':like', $this->id);
        return $this->likesCount();
    }
    public function likesCount()
    {
        $redis = Yii::$app->redis;
        return $redis->scard('post:'.$this->id.':like');
    }
    public function isLikedByUser($user)
    {
        $redis = Yii::$app->redis;
        return $redis->sismember('post:'.$this->id.':like', $user->id);
    }
}
