<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;

class PostForm extends Model
{
    const MAX_DESCRIPTION_LENGTH = 1000;

    public $picture;
    public $description;

    public function rules()
    {
        return [
            [['picture'],
                'file',
                'skipOnEmpty' => true,
                'extension' => ['jpg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
            [['description'],'string', 'max' => self::MAX_DESCRIPTION_LENGTH],
        ];
    }
    public function __construct()
    {

    }
    private function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
}