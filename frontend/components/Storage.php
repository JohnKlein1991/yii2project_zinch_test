<?php


namespace frontend\components;

use Yii;
use yii\web\UploadedFile;
use yii\base\Component;
use yii\helpers\FileHelper;

class Storage extends Component implements StorageInterface
{
    private $fileName;

    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);
        if($path && $file->saveAs($path)){
            return $this->fileName;
        }
    }
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'] . $filename;
    }

    private function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);
        $path = $this->getStoragePath() . $this->getFileName($file);

        $path = FileHelper::normalizePath($path);
//        if(FileHelper::createDirectory(dirname($path), 0777, true )){
        if(file_exists(dirname($path))){
            return $path;
        }
        if(mkdir(dirname($path), 0777, true)){
            return $path;
        }
    }
    private function getFileName(UploadedFile $file)
    {
        $hash = sha1_file($file->tempName);
        $name = substr_replace($hash, '/', 2, 0);
        $name = substr_replace($name, '/', 5, 0);
        return $name . '.'. $file->extension;
    }
    private function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }
}