<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\controllers\AdminController;
use panix\mod\mailchimp\models\forms\MemberForm;
use RuntimeException;
use Exception;
use Yii;
use panix\engine\Html;
use yii\base\DynamicModel;

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
        foreach ($lists['lists'] as $data) {
            $member_count = $data['stats']['member_count'];
            $member_unsub = $data['stats']['unsubscribe_count'];
            $result[] = [
                'name' => $data['name'],
                'subscribe' => Html::tag('span', $member_count, ['class' => 'badge badge-success']),
                'unsubscribe' => Html::tag('span', $member_unsub, ['class' => 'badge badge-danger']),
                'options' => Html::a(Html::icon('search'), ['view', 'id' => $data['id'], 'name' => $data['name']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
        $name = Yii::$app->request->get('name');
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
                'options' => Html::a(Html::icon('edit'), ['edit-member', 'list_id' => $id, 'subscriber_hash' => $member['id']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
        $name = Yii::$app->request->get('name');
        $this->pageName = Yii::t('mailchimp/default', 'CREATE_MEMBER');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'LIST', ['name' => $name]),
            'url' => ['/admin/mailchimp/default/view', 'id' => $id]
        ];
        $this->breadcrumbs[] = $this->pageName;


        $model = new MemberForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $params = [];
                $params['email_address'] = $model->email;
                $params['email_type'] = 'html';
                $params['status'] = 'subscribed';
                //$params['merge_fields'] = [];
                $response = Yii::$app->mailchimp->getListMemberCreate($id, $params);

                if (!isset($response['status'])) {
                    Yii::$app->session->setFlash('success', Yii::t('mailchimp/default', 'SUCCESS_CREATE_MEMBER'));
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', $response['title']);
                }
            }
        }
        return $this->render('create-member', [
            'model' => $model,
        ]);
    }

    public function actionEditMember($list_id, $subscriber_hash)
    {
        $response = Yii::$app->mailchimp->getClient()->get("/lists/{$list_id}/members/{$subscriber_hash}");

        $response_fields = Yii::$app->mailchimp->getClient()->get("/lists/{$list_id}/merge-fields");
        //CMS::dump($response_fields);die;

        $fields = [];
        foreach ($response_fields['merge_fields'] as $field_name => $field) {
            $fields[] = $field['tag'];
        }

        $staticFields = ['email_address', 'email_type', 'status'];
        $inputs = [];
        $model = new DynamicModel(array_merge($staticFields, $fields));

        $model->email_address = $response['email_address'];
        $model->email_type = $response['email_type'];
        $model->status = $response['status'];
        $labels=[];
        foreach ($response_fields['merge_fields'] as $field_name => $field) {
            $labels[$field['tag']]= $field['name'];
         $model->attributeLabels([$field['tag'] => $field['name']]);
            if ($field['required']) {
                $model->addRule($field['tag'], 'required');
            } else {
                $model->addRule($field['tag'], 'string');
            }
            if(isset($field['options']['size'])){
                $model->addRule($field['tag'], 'string', ['max' => $field['options']['size']]);
            }
            if($field['type'] == 'imageurl'){
                $model->addRule($field['tag'], 'url');
            }
            $inputs[$field['tag']]['type'] = $field['type'];
            $inputs[$field['tag']]['label'] = $field['name'];
            if(isset($field['options'])){
                if(isset($field['options']['choices'])){
                    $inputs[$field['tag']]['items'] = $field['options']['choices'];
                }

            }
        }

        foreach ($response['merge_fields'] as $field_name => $field) {
            $model->{$field_name} = $field;
        }

        $model->addRule(['email_address'], 'email');
        $model->addRule(['email_type'], 'string');
        $model->addRule(['status'], 'string');
        $model->addRule(['status'], 'required');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $data = [];
                foreach ($model->attributes as $key => $attribute) {
                    $data[$key] = $attribute;
                    if (!in_array($key, $staticFields)) {
                        $data['merge_fields'][$key] = $attribute;
                    }
                }

                $response = Yii::$app->mailchimp->getClient()->patch("/lists/{$list_id}/members/{$subscriber_hash}", $data);

                //if (!isset($response['status'])) {
                Yii::$app->session->setFlash('success', Yii::t('mailchimp/default', 'SUCCESS_UPDATE_MEMBER'));
                return $this->refresh();
                //} else {
                //    print_r($response);die;
                //    Yii::$app->session->setFlash('error', $response['title']);
                // }
            }
        }

        return $this->render('edit-member', [
            'model' => $model,
            'inputs' => $inputs
        ]);
    }
}
