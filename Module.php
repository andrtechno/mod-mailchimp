<?php

namespace panix\mod\mailchimp;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'mailchimp';
    // Show Firstname in Widget
    public $showFirstname = true;

    // Show Lastname in Widget
    public $showLastname = true;

    // Show Titles in the views
    public $showTitles = false;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->setComponents([
            'mailchimp' => ['class' => 'panix\mod\mailchimp\components\Mailchimp'],
        ]);

    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
                        //'url' => ['/admin/contacts'],
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
                                'url' => ['/admin/mailchimp'],
                                'icon' => 'user-outline',
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'CAMPAIGNS'),
                                'url' => ['/admin/mailchimp/campaigns'],
                                'icon' => 'arrow-right',
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'AUTOMATIONS'),
                                'url' => ['/admin/mailchimp/automations'],
                                'icon' => 'arrow-right',
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'TEMPLATES'),
                                'url' => ['/admin/mailchimp/templates'],
                                'icon' => 'brush',
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                "url" => ['/admin/mailchimp/settings'],
                                'icon' => 'settings'
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    public function getInfo()
    {
        return [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'author' => 'andrew.panix@gmail.com',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('mailchimp/default', 'MODULE_DESC'),
            'url' => ['/admin/mailchimp'],
        ];
    }
}
