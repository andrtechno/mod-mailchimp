<?php

namespace panix\mod\mailchimp\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class TemplatesForm
 * @package panix\mod\mailchimp\models\forms
 */
class TemplatesForm extends Model
{

    protected $module = 'mailchimp';

    public $name;
    public $html;
    public $folder_id;


    public function rules()
    {
        $rules[] = [['name', 'html'], "required"];
        $rules[] = ['folder_id', "string"];
        return $rules;
    }


}