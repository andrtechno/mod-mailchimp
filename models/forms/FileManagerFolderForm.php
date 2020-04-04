<?php

namespace panix\mod\mailchimp\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class FileManagerFolderForm
 * @package panix\mod\mailchimp\models\forms
 */
class FileManagerFolderForm extends Model
{

    protected $module = 'mailchimp';

    public $name;


    public function rules()
    {
        $rules[] = [['name'], "required"];
        $rules[] = ['name', "string"];
        return $rules;
    }


}