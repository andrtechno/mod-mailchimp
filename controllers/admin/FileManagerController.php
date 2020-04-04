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
 * Class FileManagerController
 */
class FileManagerController extends AdminController
{


    /**
     * Displays Lists view
     *
     * @return mixed
     * @throws Exception
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('mailchimp/default', 'FILE_MANAGER');
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;
        $response = Yii::$app->mailchimp->getClient()->get("file-manager/files");

        $result = [];
//CMS::dump($response['files']);die;
        foreach ($response['files'] as $data) {
            $result[] = [
                'name' => $data['name'],
                'thumbnail' => Html::a(Html::img($data['thumbnail_url'], ['style' => 'width:100px', 'class' => 'img-thumbnail']), $data['full_size_url'], ['class' => 'thumbnail']),
                'file_size' => CMS::fileSize($data['size']),
                'size' => $data['width'] . 'x' . $data['height'],
                //'status' => Html::tag('span',$data['status'],['class'=>'badge badge-secondary']),
                'created_at' => CMS::date(strtotime($data['created_at'])),
                'options' => Html::a(Html::icon('delete'), ['delete', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']) . Html::a(Html::icon('brush'), ['content', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']),
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


    public function actionUpload()
    {
        //$response = Yii::$app->mailchimp->getClient()->post("file-manager/files");
        return $this->render('upload', [
            'response' => $response,
        ]);
    }

    public function actionDelete($id)
    {
        $response = Yii::$app->mailchimp->getClient()->delete("file-manager/files/{$id}");
        if ($response) {
            Yii::$app->session->setFlash('success', Yii::t('app/default', 'FILE_SUCCESS_DELETE'));
        } else {
            Yii::$app->session->setFlash('success', 'FILE_ERROR_DELETE');
        }
        return $this->redirect(['index']);
    }

}
