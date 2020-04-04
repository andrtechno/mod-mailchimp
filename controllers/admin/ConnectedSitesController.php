<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\Html;
use panix\engine\controllers\AdminController;
use panix\mod\mailchimp\models\forms\ConnectedSitesForm;
use RuntimeException;
use Exception;
use Yii;
use yii\helpers\Url;

/**
 * Class ConnectedSitesController
 */
class ConnectedSitesController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'CONNECTED_SITES');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;
        $response = Yii::$app->mailchimp->getConnectedSites();

        foreach ($response['sites'] as $data) {
            $result[] = [
                'domain' => $data['domain'] . '<br/>' . Html::tag('span', 'platform: ' . $data['platform'], ['class' => 'badge badge-secondary']),
                'site_script' => $data['site_script'],
                'created_at' => CMS::date(strtotime($data['created_at']), false),
                'updated_at' => CMS::date(strtotime($data['updated_at'])),
            ];
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
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

        return $this->render('view', [
            'data' => $data,
        ]);
    }

    public function actionCreate(){

        $model = new ConnectedSitesForm();


        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

               //  $response = Yii::$app->mailchimp->getClient()->patch("/lists/{$list_id}/members/{$subscriber_hash}", $data);

                Yii::$app->session->setFlash('success', Yii::t('mailchimp/default', 'SUCCESS_CREATE_CONNECTED_SITES'));
                return $this->refresh();

            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

}
