<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $content
 * @property int $created_at
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'content', 'created_at'], 'required'],
            [['post_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }
    public function getCommentsByPostId($id)
    {
        return self::findAll(['post_id' => $id]);
    }
}
