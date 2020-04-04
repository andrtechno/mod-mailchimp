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
 * Class ReportController
 */
class ReportController extends AdminController
{


    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'REPORTS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $response = Yii::$app->mailchimp->getClient()->get('reports');
        foreach ($response['lists'] as $data) {
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

    public function actionView($campaign_id)
    {
        $response = Yii::$app->mailchimp->getClient()->get("reports/{$campaign_id}");
        CMS::dump($response);die;
    }


}
