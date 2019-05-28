<?php


namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use Faker;

class ProfileController extends Controller
{
    public function actionView($nickname)
    {
        $currentUser = Yii::$app->user->identity;
         return $this->render(
             'view',
             [
                 'user' => $this->findUser($nickname),
                 'currentUser' => $currentUser
             ]
         );
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