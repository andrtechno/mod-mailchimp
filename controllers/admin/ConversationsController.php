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
 * Class ConversationsController
 */
class ConversationsController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'CONVERSATIONS');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;
        $response = Yii::$app->mailchimp->getClient()->get("conversations");

CMS::dump($response);die;
        foreach ($response['landing_pages'] as $data) {
            $result[] = [
                'name'=>$data['name'],
                'title'=>$data['title'],
                'description' => $data['description'],
                'status' => Html::tag('span',$data['status'],['class'=>'badge badge-secondary']),
               // 'needs_block_refresh' => ($data['needs_block_refresh'])?'yes':'no',
                'options' => Html::a(Html::icon('search'), ['view', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']).Html::a(Html::icon('brush'), ['content', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
        $response = Yii::$app->mailchimp->getClient()->get("landing-pages/{$id}");
        return $this->render('view', [
            'response' => $response,
        ]);
    }

    public function actionContent($id){
        $response = Yii::$app->mailchimp->getClient()->get("landing-pages/{$id}/content");

        return $this->render('content', [
            'response' => $response,
        ]);
    }

}
