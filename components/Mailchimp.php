<?php

namespace panix\mod\mailchimp\components;

use DrewM\MailChimp\MailChimp as BaseMailchimp;
use Exception;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\HttpException;

/**
 * Class Mailchimp
 *
 * @property BaseMailchimp $client
 * @property array $lists
 */
class Mailchimp extends Component
{


    /**
     * @var BaseMailchimp
     */
    private $_mailchimp;


    /**
     * Mailchimp init
     *
     * @throws Exception
     */
    public function init()
    {
        $this->_mailchimp = new BaseMailchimp(Yii::$app->settings->get('mailchimp', 'api_key'));

        parent::init();
    }

    /**
     * @return BaseMailchimp
     */
    public function getClient()
    {
        return $this->_mailchimp;
    }

    /**
     * Get Mailchimp Lists
     *
     * @return array
     */
    public function getLists()
    {
        return $this->_mailchimp->get('lists');
    }

    /**
     * Get List Members
     *
     * @param string $id
     * @param string $method
     * @return \yii\base\Exception
     * @return array
     */
    public function getListMembers($id)
    {
        return $this->_mailchimp->get("lists/{$id}/members");
    }

    public function getListMemberCreate($id, $params)
    {
        return $this->_mailchimp->post("lists/{$id}/members", $params);
    }

    /**
     * Get Mailchimp Automations
     *
     * @return array
     */
    public function getAutomations()
    {
        return $this->_mailchimp->get('automations');
    }

    public function getBatches()
    {
        return $this->_mailchimp->get('batches');
    }

    public function getTemplates($id = false, $method = 'get')
    {
        if ($id) {
            $method_name = 'templates/' . $id;
        } else {
            $method_name = 'templates';
        }
        $response = $this->_mailchimp->$method($method_name);
        if (isset($response['status'])) {
            if ($response['status'] == 404) {
                throw new HttpException(404, $response['title'] . ' ' . $response['detail']);
            } else {
                throw new InvalidConfigException($response['title'] . ' ' . $response['detail']);
            }
        }
        return $response;
    }

    public function getCampaigns()
    {
        return $this->_mailchimp->get('campaigns');
    }

    /**
     * Campaigns Update|Delete|Get
     *
     * @param $id
     * @param string $method
     * @return \yii\base\Exception
     */
    public function getCampaignsById($id, $method = 'get')
    {
        if (!in_array($method, ['get', 'delete', 'patch'])) {
            return new \yii\base\Exception();
        }
        return $this->_mailchimp->$method("campaigns/" . $id);
    }

}
