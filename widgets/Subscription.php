<?php


namespace panix\mod\mailchimp\widgets;

use DrewM\MailChimp\MailChimp;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap4\Widget;
use yii\helpers\Html;
use yii\web\Request;

/**
 * Class Subscription
 */
class Subscription extends \panix\engine\data\Widget
{
	/**
	 * @var string $list_id
	 */
    public $list_id;

	/**
	 * @var array $list_array
	 */
    public $list_array;

	/**
	 * @var Request
	 */
	private $_post;

	/**
	 * @var MailChimp
	 */
    private $_mailchimp;

	/**
	 * @throws InvalidConfigException
	 */
	public function init()
    {
	    if (!$this->list_id && !$this->list_array) {
	        throw new InvalidConfigException(Yii::t('mailchimp/default','You must define Mailchimp ListID!'));
	    }

	    if($this->list_array) {
	        $this->list_id = $this->list_array[Yii::$app->language];
	    }

	    $this->_mailchimp = Yii::$app->mailchimp->getClient();
	    $this->_post = Yii::$app->request->post();

	    parent::init();
    }

	/**
	 * @return string|void
	 */
	public function run()
    {
	    $class   = '';
	    $fname   = '';
	    $lname   = '';
	    $email   = '';
	    $message = '';
	    $submit  = null;

	    if($this->_post) {
		    $email  = $this->_post['subscribe-email'];
		    $fname  = isset($this->_post['subscribe-first-name']) ? $this->_post['subscribe-first-name'] : '';
		    $lname  = isset($this->_post['subscribe-last-name']) ? $this->_post['subscribe-last-name'] : '';
		    $submit = $this->_post['subscribe-submit'];
	    }

	    if($submit !== null)
	    {
		    $result = $this->_mailchimp->post('lists/' .$this->list_id. '/members', [
			    'merge_fields' => [
				    'FNAME' => $fname,
				    'LNAME' => $lname
			    ],
			    'email_address' => $email,
			    'status' => 'subscribed',
		    ]);

		    if ($this->_mailchimp->success()) {
			    $class   = 'alert-success';
			    $message = $result['email_address']. ' ' .$result['status'];
		    } else {
			    $class   = 'alert-warning';
			    $message = $result['title'];
		    }
	    }
        return $this->render($this->skin,['message'=>$message,'class'=>$class]);

    }
}
