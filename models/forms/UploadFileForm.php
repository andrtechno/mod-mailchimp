<?php

namespace panix\mod\mailchimp\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class UploadFileForm
 * @package panix\mod\mailchimp\models\forms
 */
class UploadFileForm extends Model
{

    protected $module = 'mailchimp';

    public $file;


    public function rules()
    {
        $rules[] = [['file'], "required"];
        $rules[] = [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'];
        return $rules;
    }

    public function upload(){
        $tmpfile = UploadedFile::getInstance($this, 'file');
        $tmpfile_contents = file_get_contents( $tmpfile->tempName );
        $this->file = base64_encode($tmpfile_contents);
        $response = Yii::$app->mailchimp->getClient()->post("/file-manager/files",[
            'name'=>$tmpfile->name,
            'file_data'=>$this->file
        ]);
        return $response;
    }

}