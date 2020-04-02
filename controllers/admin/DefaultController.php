<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\controllers\AdminController;
use RuntimeException;
use Exception;
use Yii;
use panix\engine\Html;

/**
 * Class DefaultController
 */
class DefaultController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'LISTS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $lists = Yii::$app->mailchimp->getLists();

        return $this->render('index', [
            'items' => $lists['lists'],
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

        $this->pageName = Yii::t('mailchimp/default', 'LISTS ' . $name);
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
                'ip_opt' => $member['ip_opt'],
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
            'members' => $members['members'],
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
