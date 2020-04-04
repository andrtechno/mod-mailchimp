<?php

namespace panix\mod\mailchimp\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class FileManagerUploadForm
 * @package panix\mod\mailchimp\models\forms
 */
class FileManagerUploadForm extends Model
{

    protected $module = 'mailchimp';

    public $file;


    public function rules()
    {
        $rules[] = [['file'], "required"];
        $rules[] = [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'];
        return $rules;
    }


}