<?php

namespace panix\mod\mailchimp\components;

use DrewM\MailChimp\MailChimp as BaseMailchimp;
use Exception;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class Mailchimp
 *
 * @property BaseMailchimp $client
 * @property array $lists
 */
class Mailchimp extends Component
{
    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var BaseMailchimp
     */
    private $_mailchimp;

    /**
     * Mailchimp constructor
     *
     * @param array $config
     *
     * @throws InvalidConfigException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['apiKey']) || !$config['apiKey']) {
            throw new InvalidConfigException(Yii::t('mailchimp', 'Mailchimp API Key missing!'));
        }

        $this->apiKey = $config['apiKey'];

        parent::__construct($config);
    }

    /**
     * Mailchimp init
     *
     * @throws Exception
     */
    public function init()
    {
        $this->_mailchimp = new BaseMailchimp($this->apiKey);

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
     *
     * @return array
     */
    public function getListMembers($id)
    {
        return $this->_mailchimp->get("lists/{$id}/members");
    }

    /**
     * Get Mailchimp Campaign Folders
     *
     * @return array
     */
    public function getCampaignFolders()
    {
        return $this->_mailchimp->get('campaign-folders');
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
