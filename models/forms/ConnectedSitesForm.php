<?php

namespace panix\mod\mailchimp\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class ConnectedSitesForm
 * @package panix\mod\mailchimp\models\forms
 */
class ConnectedSitesForm extends Model
{

    protected $module = 'mailchimp';

    public $foreign_id;
    public $domain;






    public function rules()
    {
        $rules[] = [['foreign_id','domain'], "required"];
      //  $rules[] = ['email', "email"];
        return $rules;
    }


}