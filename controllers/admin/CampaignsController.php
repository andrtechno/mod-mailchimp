<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\controllers\AdminController;
use RuntimeException;
use Exception;
use Yii;

/**
 * Class CampaingsController
 */
class CampaignsController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'CAMPAIGNS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;
        $data = Yii::$app->mailchimp->getCampaigns();
        return $this->render('index', [
            'items' => $data['campaigns'],
        ]);
    }

    /**
     * Displays a single List view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionView($id)
    {
        $data = Yii::$app->mailchimp->getCampaignsById($id);
        return $this->render('view', [
            'data' => $data,
        ]);
    }

}
