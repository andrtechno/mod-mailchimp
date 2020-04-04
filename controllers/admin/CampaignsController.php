<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\Html;
use panix\engine\controllers\AdminController;
use RuntimeException;
use Exception;
use Yii;
use yii\helpers\Url;

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
        $response = Yii::$app->mailchimp->getCampaigns();

//CMS::dump($response);die;
        foreach ($response['campaigns'] as $data) {
            $statusClass = ($data['status'] == 'save') ? 'success' : 'warning';
            $result[] = [
                'name' => $data['settings']['title'] . '<br>' . $data['type'] . ' > ' . Html::a($data['recipients']['list_name'], ['/admin/mailchimp/default/view', 'id' => $data['recipients']['list_id'], 'name' => $data['recipients']['list_name']]),
                'url' => Html::a('See template', Url::to($data['long_archive_url'])),
                'emails_sent' => Html::tag('span', $data['emails_sent'], ['class' => 'badge badge-secondary']),
                'status' => Html::tag('span', ucfirst($data['status']), ['class' => 'badge badge-' . $statusClass]),
                'needs_block_refresh' => ($data['needs_block_refresh']) ? 'yes' : 'no',
                'options' => Html::a(Html::icon('brush'), ['edit-template', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']) . Html::a(Html::icon('search'), ['view', 'id' => $data['id'], 'name' => $data['settings']['title']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
        $response = Yii::$app->mailchimp->getCampaignsById($id);
        $name = Yii::$app->request->get('name');


        $this->pageName = Yii::t('mailchimp/default', 'CAMPAIGNS_NAME', $name);
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'CAMPAIGNS'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;


        /*$responseTest = Yii::$app->mailchimp->getClient()->post("campaigns/{$id}/actions/test", [
            'send_type' => Yii::$app->settings->get('mailchimp', 'test_send_type'),
            'test_emails' => explode(',', Yii::$app->settings->get('mailchimp', 'test_emails'))
        ]);*/
        if (Yii::$app->request->post('send_test')) {
            $responseTest = Yii::$app->mailchimp->getClient()->post("campaigns/{$id}/actions/test", [
                'send_type' => Yii::$app->settings->get('mailchimp', 'test_send_type'),
                'test_emails' => explode(',', Yii::$app->settings->get('mailchimp', 'test_emails'))
            ]);

            if ($responseTest) {
                Yii::$app->session->setFlash('success', 'Тестовое письмо отправлено.');
            }
        }
        if (Yii::$app->request->post('send')) {
            $responseSend = Yii::$app->mailchimp->getClient()->post("campaigns/{$id}/actions/send");

            if (Yii::$app->mailchimp->getClient()->success()) {
                Yii::$app->session->setFlash('success', 'Письмо отправлено.');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('mailchimp/default', 'RESPONSE_ERROR', [
                    $responseSend['status'],
                    $responseSend['title'],
                    $responseSend['detail']
                ]));
            }
        }


        return $this->render('view', [
            'response' => $response,
            'id' => $id
        ]);
    }

    public function actionEditTemplate($id)
    {
        $response = Yii::$app->mailchimp->getClient()->get("campaigns/{$id}/content");


        return $this->render('edit-template', [
            'response' => $response,
        ]);
    }

}
