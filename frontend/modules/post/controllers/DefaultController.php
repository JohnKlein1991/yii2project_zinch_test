<?php

namespace frontend\modules\post\controllers;

use frontend\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\modules\post\models\forms\PostForm;
use yii\web\Response;
use Yii;
use frontend\models\PostComments;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public function actionCreate()
    {
        $model = new PostForm(Yii::$app->user->identity);
        if ($model->load(Yii::$app->request->post())){
            $model->picture = UploadedFile::getInstance($model, 'picture');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Post created');
                return $this->goHome();
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'post' => $this->findPost($id),
            'user' => Yii::$app->user->identity,
            'comments' => PostComments::findAll(['post_id' => $id])
        ]);
    }
    public function actionLike()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        $id = Yii::$app->request->post('id');
        if($id){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $this->findPost($id);
            $user = Yii::$app->user->identity;
            $count = $post->like($user);
            return [
                'result' => 'success',
                'count' => $count
            ];
        }
    }
    public function actionDislike()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        $id = Yii::$app->request->post('id');
        if($id){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $this->findPost($id);
            $user = Yii::$app->user->identity;
            $count = $post->dislike($user);
            return [
                'result' => 'success',
                'count' => $count
            ];
        }
    }
    public function actionAddComment()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        $content = Yii::$app->request->post('content');
        $postId = Yii::$app->request->post('id');
        $userId = Yii::$app->user->identity->id;
        $model = new PostComments();
        $model->post_id = $postId;
        $model->user_id = $userId;
        $model->content = $content;
        $model->created_at = time();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->save()){
            return [
                'result' => 'Comment has been added successfully!'
            ];
        } else {
            var_dump($model->getErrors());
            var_dump($model->errors);
            return [
                'result' => 'OOps!!'
            ];
        }
    }
    public function findPost($id)
    {
        if($user = Post::findOne(['id' => $id])){
            return $user;
        } else {
            throw new NotFoundHttpException();
        }
    }
    public function getComments()
    {
        $comments = PostComments::findAll();
    }
}
