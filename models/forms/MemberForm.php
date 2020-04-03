<?php

namespace panix\mod\mailchimp\models\forms;

use panix\engine\base\Model;
use panix\engine\CMS;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * Class MemberForm
 * @package panix\mod\mailchimp\models\forms
 */
class MemberForm extends DynamicModel
{

    protected $module = 'mailchimp';

    public $email;
    //public $firstname;
    //public $lastname;
    public $type;
    public $status;
   // public $phone;
   // public $address;
   // public $birthday;


    public $list_id;
    public $subscriber_hash;
    private $_response;
    private $_response_fields;


    public function init2()
    {
        $this->_response_fields = Yii::$app->mailchimp->getClient()->get("/lists/{$this->list_id}/merge-fields");
       // CMS::dump($this->_response_fields);die;
        if ($this->list_id && $this->subscriber_hash) {
            $this->_response = Yii::$app->mailchimp->getClient()->get("/lists/{$this->list_id}/members/{$this->subscriber_hash}");

            $this->type = $this->_response['email_type'];
           $this->status = $this->_response['status'];

          //  $this->firstname = $this->_response['merge_fields']['FNAME'];
          //  $this->lastname = $this->_response['merge_fields']['LNAME'];
          //  $this->phone = $this->_response['merge_fields']['PHONE'];
          //  $this->birthday = $this->_response['merge_fields']['BIRTHDAY'];
          //  $this->address = $this->_response['merge_fields']['ADDRESS'];
            foreach ($this->_response_fields['merge_fields'] as $field) {

                $this->dynamicFields[$field['tag']] = $this->_response['merge_fields'][$field['tag']];
                if ($field['required']) {
                    $this->dynamicRules[] = [$field['tag'], "required"];
                }

            }
           // Yii::configure($this, $this->dynamicFields);

        } elseif ($this->scenario == 'add') {
            $this->email = $this->_response['email_address'];
            $this->_response = Yii::$app->mailchimp->getClient()->get("/lists/{$this->list_id}/members");
        }
        parent::init();


        foreach ($this->_response_fields['merge_fields'] as $field) {
            //$this->{$field['tag']} = null;
            if ($field['required']) {
                $this->dynamicRules[] = [$field['tag'], "required"];
            }

        }
        //CMS::dump($field);
        //die;

    }

    public function rules2()
    {
        $rules[] = [['email'], "required"];
        $rules[] = ['email', "email"];
        return ArrayHelper::merge($rules, $this->dynamicRules);
    }
    private $dynamicFields = [];
    private $dynamicRules = [];
    public function setDynamicFields2($aryDynamics)
    {
        $this->dynamicFields = $aryDynamics;
    }

    public function setDynamicRules2($aryDynamics)
    {
        $this->dynamicRules = $aryDynamics;
    }

    public function __get2($name)
    {
        if (isset($this->dynamicFields[$name])) {
            return $this->dynamicFields[$name];
        }

        return parent::__get($name);
    }

    public function __set2($name, $value)
    {
        if (isset($this->dynamicFields[$name])) {
            return $this->dynamicFields[$name] = $value;
        }
        return parent::__set($name, $value);
    }

}