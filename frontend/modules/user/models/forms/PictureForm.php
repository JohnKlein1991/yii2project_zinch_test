<?php
namespace frontend\modules\user\models\forms;

use yii\base\Model;
use Yii;

class PictureForm extends Model
{
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'extension' => 'jpg',
                'checkExtensionByMimeType' => true
             ]
        ];
    }
    public function save()
    {
        return true;
    }
}