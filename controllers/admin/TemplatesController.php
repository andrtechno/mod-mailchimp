<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\controllers\AdminController;
use panix\mod\mailchimp\models\forms\TemplatesForm;
use RuntimeException;
use Exception;
use Yii;
use panix\engine\Html;

/**
 * Class TemplatesController
 */
class TemplatesController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'TEMPLATES');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $response = Yii::$app->mailchimp->getTemplates();
//CMS::dump($response);die;
        foreach ($response['templates'] as $data) {
            $result[] = [
                'name' => $data['name'],
                'thumbnail' => Html::a(Html::img($data['thumbnail'],['width'=>100,'class'=>'img-thumbnail']),$data['thumbnail'],['class'=>'thumbnail']),
                'type' => Html::tag('span',$data['type'],['class'=>'badge badge-secondary']),
                'category' => Html::tag('span',$data['category'],['class'=>'badge badge-secondary']),
                //'responsive' => Html::tag('span',(($data['responsive'])?'yes':'no'),['class'=>'badge badge-secondary']),
                'responsive' => $data['responsive'],
                'date_created' => strtotime($data['date_created']),
                'date_edited' => strtotime($data['date_edited']),
                'options' => Html::a(Html::icon('edit'), ['update', 'id' => $data['id'], 'name' => $data['name']], ['class' => 'btn btn-sm btn-outline-secondary']).''.Html::a(Html::icon('search'), ['view', 'id' => $data['id'], 'name' => $data['name']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
        $response = Yii::$app->mailchimp->getTemplates($id);

        $this->pageName = Yii::t('mailchimp/default', 'LIST', ['name' => $name]);
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $result = [];
CMS::dump($response);die;
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

    public function actionUpdate($id = false){


       $model = new TemplatesForm();
        $response2 = Yii::$app->mailchimp->getClient()->get("campaigns/8f73d79a42/content");
        //CMS::dump($response2);die;
        if($id){
            $response = Yii::$app->mailchimp->getTemplates($id);
            CMS::dump($response);die;
            $model->html = $response['html'];
        }





        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {


                if($id){

                }else{

                    $response = Yii::$app->mailchimp->getClient()->post('templates',$model->attributes);
                }
                Yii::$app->session->setFlash('success', Yii::t('mailchimp/default', 'SUCCESS_CREATE_TEMPLATE'));
                return $this->refresh();

            }
        }
       // CMS::dump($response);die;
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
