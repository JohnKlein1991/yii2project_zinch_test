<?php

namespace frontend\modules\post\models\forms;

use frontend\components\Storage;
use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;

class PostForm extends Model
{
    const MAX_DESCRIPTION_LENGTH = 1000;

    public $picture;
    public $description;
    private $user;

    public function rules()
    {
        return [
            [['picture'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => ['jpg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
            [['description'],'string', 'max' => self::MAX_DESCRIPTION_LENGTH],
        ];
    }
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function save()
    {
        if($this->validate()){
            $model = new Post();
            $model->description = $this->description;
            $model->created_at = time();
            $model->filename = Yii::$app->storage->saveUploadedFile($this->picture);
            $model->user_id = $this->user->id;
            $model->save(false );
        }
    }
    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
}