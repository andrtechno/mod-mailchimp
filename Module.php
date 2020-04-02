<?php

namespace panix\mod\mailchimp;

use Yii;
use panix\engine\WebModule;
use yii\i18n\PhpMessageSource;

class Module extends WebModule
{

    public $icon = 'mailchimp';
    // Show Firstname in Widget
    public $showFirstname = true;

    // Show Lastname in Widget
    public $showLastname = true;

    // Show Titles in the views
    public $showTitles = false;

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
                                'label' => Yii::t('mailchimp/default', 'CAMPAIGNS'),
                                'url' => ['/admin/mailchimp/campaigns'],
                                //'icon' => 'location-map',
                            ],
                            [
                                'label' => Yii::t('contacts/admin', 'MARKERS'),
                                'url' => ['/admin/mailchimp/markers'],
                                //'icon' => 'location-marker',
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
}
