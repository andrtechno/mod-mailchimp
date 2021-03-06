<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\controllers\AdminController;
use RuntimeException;
use Exception;
use Yii;
use panix\engine\Html;

/**
 * Class AutomationsController
 */
class AutomationsController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'AUTOMATIONS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $response = Yii::$app->mailchimp->getAutomations();

        foreach ($response['automations'] as $data) {
            $result[] = [
                'name' => $data['settings']['title'],
                'emails_sent' => Html::tag('span',$data['emails_sent'],['class'=>'badge badge-secondary']),
                'create_time' => strtotime($data['create_time']),
                'options' => Html::a(Html::icon('search'), ['view', 'id' => $data['id'], 'name' => $data['settings']['title']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
        $request = Yii::$app->request;
        $name = $request->get('name');
        $members = Yii::$app->mailchimp->getListMembers($id);

        $this->pageName = Yii::t('mailchimp/default', 'LIST', ['name' => $name]);
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $result = [];

        foreach ($members['members'] as $member) {


            $firstname = isset($member['merge_fields']['FNAME']) ? ucwords(strtolower($member['merge_fields']['FNAME'])) : '';
            $lastname = isset($member['merge_fields']['LNAME']) ? ucwords(strtolower($member['merge_fields']['LNAME'])) : '';

            if (isset($member['merge_fields']['NAME'])) {
                $name = ucwords(strtolower($member['merge_fields']['NAME']));
            } elseif ($firstname && $lastname) {
                $name = $firstname . ' ' . $lastname;
            } else {
                $name = '';
            }


            if ($member['status'] == 'subscribed') {
                $class = 'success';
            } elseif ($member['status'] == 'unsubscribed') {
                $class = 'danger';
            } elseif ($member['status'] == 'cleaned') {
                $class = 'secondary';
            } elseif ($member['status'] == 'pending') {
                $class = 'warning';
            } elseif ($member['status'] == 'transactional') {
                $class = 'secondary';
            } elseif ($member['status'] == 'archived') {
                $class = 'secondary';
            } else {
                $class = 'secondary';
            }

            $result[] = [
                'name' => $name,
                'status' => Html::tag('span', Yii::t('mailchimp/default', mb_strtoupper($member['status'])), ['class' => 'badge badge-' . $class]),
                'email' => Html::mailto($member['email_address'], $member['email_address']),
                'ip_opt' => CMS::ip($member['ip_opt']),
                'date' => strtotime($member['timestamp_opt']),

            ];


        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);


        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'id' => $id,
            'name' => $name
        ]);
    }

    public function actionCreateMember($id)
    {
        $params = [];
        $params['email_address'] = 'dev@pixelion.com.ua';
        $params['email_type'] = 'html';
        $params['status'] = 'subscribed';

        $members = Yii::$app->mailchimp->getListMemberCreate($id, $params);
        if (isset($members->status)) {
            CMS::dump($members);
            die;
        }
        CMS::dump($members);
    }
}
