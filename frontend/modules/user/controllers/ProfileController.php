<?php


namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use Faker;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use yii\web\Response;

class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        $pictureModel = new PictureForm();
        $currentUser = Yii::$app->user->identity;
        if($currentUser){
            return $this->render(
                'view',
                [
                    'user' => $this->findUser($nickname),
                    'currentUser' => $currentUser,
                    'pictureModel' => $pictureModel
                ]
            );
        } else {
            return $this->redirect(['/user/default/login']);
        }
    }
    public function actionSubscribe($id)
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $user = $this->getUserById($id);
        $currentUser->followUser($user);
        return $this->redirect([
            '/user/profile/view',
            'nickname' => $user->getNickname()
        ]);
    }
    public function actionUnsubscribe($id)
    {
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        $user = $this->getUserById($id);
        $currentUser->unfollowUser($user);
        return $this->redirect([
            '/user/profile/view',
            'nickname' => $user->getNickname()
        ]);
    }
    public function actionUploadPicture()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');
        if($model->validate()){
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage ->saveUploadedFile($model->picture);
            if($user->save(false, ['picture'])){
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture)
                ];
            }
        }
        return [
          'success' => false,
          'errors' => $model->getErrors( )
        ];

    }

    private function findUser($nickname)
    {
        $user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one();
        return $user;
    }
    private function getUserById($id)
    {
        return User::find()->where(['id' => $id])->one();
    }
//    public function actionGenerate()
//    {
//        $faker = Faker\Factory::create();
//        for($i = 0;$i < 1000;$i++){
//            $user = new User([
//                'username' => $faker->name,
//                'email' => $faker->email,
//                'about' => $faker->realText(300),
//                'nickname' => $faker->regexify('[A-Za-z0-9_]{5,15}'),
//                'auth_key' => Yii::$app->security->generateRandomString(),
//                'password_hash' => Yii::$app->security->generateRandomString(),
//                'created_at' => $time = time(),
//                'updated_at' => $time,
//            ]);
//            $user->save(false);
//        }
//    }
}