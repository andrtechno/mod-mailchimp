<?php

namespace panix\mod\mailchimp\models;

use Yii;
use panix\engine\SettingsModel;

/**
 * Class SettingsForm
 * @package panix\mod\mailchimp\models
 */
class SettingsForm extends SettingsModel
{

    public static $category = 'mailchimp';
    protected $module = 'mailchimp';

    public $api_key;
    public $list_user;
    public $list_order;
    public $list_feedback;
    public $test_emails;
    public $test_send_type;

    public function rules()
    {
        return [
            [['api_key'], "required"],
            [['api_key', 'list_user','test_emails','test_send_type'], 'string'],
            [['list_user', 'list_order', 'list_feedback'], "required", 'on' => ['api']],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'api_key' => '',
            'list_user' => null,
            'list_order' => null,
            'list_feedback' => null,
            'test_emails'=>'',
            'test_send_type'=>'',
        ];
    }
}