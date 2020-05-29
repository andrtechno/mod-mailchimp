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
                                'visible' => Yii::$app->user->can('/mailchimp/admin/default/index') || Yii::$app->user->can('/mailchimp/admin/default/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'CAMPAIGNS'),
                                'url' => ['/admin/mailchimp/campaigns'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/default/index') || Yii::$app->user->can('/mailchimp/admin/default/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'AUTOMATIONS'),
                                'url' => ['/admin/mailchimp/automations'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/automations/index') || Yii::$app->user->can('/mailchimp/admin/automations/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'TEMPLATES'),
                                'url' => ['/admin/mailchimp/templates'],
                                'icon' => 'brush',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/templates/index') || Yii::$app->user->can('/mailchimp/admin/templates/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'CONNECTED_SITES'),
                                'url' => ['/admin/mailchimp/connected-sites'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/connected-sites/index') || Yii::$app->user->can('/mailchimp/admin/connected-sites/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'FILE_MANAGER'),
                                'url' => ['/admin/mailchimp/file-manager'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/file-manager/index') || Yii::$app->user->can('/mailchimp/admin/file-manager/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'ECOMMERCE'),
                                'url' => ['/admin/mailchimp/ecommerce'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/ecommerce/index') || Yii::$app->user->can('/mailchimp/admin/ecommerce/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'CONVERSATIONS'),
                                'url' => ['/admin/mailchimp/conversations'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/conversations/index') || Yii::$app->user->can('/mailchimp/admin/conversations/*')
                            ],
                            [
                                'label' => Yii::t('mailchimp/default', 'LANDING_PAGE'),
                                'url' => ['/admin/mailchimp/landing-page'],
                                'icon' => 'arrow-right',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/landing-page/index') || Yii::$app->user->can('/mailchimp/admin/landing-page/*')
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                "url" => ['/admin/mailchimp/settings'],
                                'icon' => 'settings',
                                'visible' => Yii::$app->user->can('/mailchimp/admin/settings/index') || Yii::$app->user->can('/mailchimp/admin/settings/*')
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    public function getAdminSidebar()
    {
        $menu = $this->getAdminMenu();
        return $menu['modules']['items'][0]['items'];
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
