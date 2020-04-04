<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\Html;
use panix\engine\controllers\AdminController;
use panix\mod\mailchimp\models\forms\UploadFileForm;
use RuntimeException;
use Exception;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

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
        $folder = Yii::$app->request->get('folder');
        $response = Yii::$app->mailchimp->getClient()->get("file-manager/files");
        if ($folder) {
            //  $response = Yii::$app->mailchimp->getClient()->get("file-manager/folders/{$folder}");
            //CMS::dump($response);die;
        }


        $result = [];

        foreach ($response['files'] as $data) {
            $folder = null;
            if ($data['folder_id']) {
                $responseFolder = Yii::$app->mailchimp->getClient()->get("file-manager/folders/{$data['folder_id']}");
                // CMS::dump($responseFolder);die;
                $folder = Html::a($responseFolder['name'], ['index', 'folder' => $responseFolder['id']]);
            }
            $result[] = [
                'name' => $data['name'],
                'folder' => Html::tag('span', $folder, ['class' => 'badge badge-secondary']),
                'thumbnail' => Html::a(Html::img($data['thumbnail_url'], ['style' => 'width:100px', 'class' => 'img-thumbnail']), $data['full_size_url'], ['class' => 'thumbnail']),
                'file_size' => CMS::fileSize($data['size']),
                'size' => $data['width'] . ' x ' . $data['height'],
                //'status' => Html::tag('span',$data['status'],['class'=>'badge badge-secondary']),
                'created_at' => strtotime($data['created_at']),
                'options' => Html::a(Html::icon('delete'), ['delete', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']),
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
            'total_file_size' => CMS::fileSize($response['total_file_size']),
            'total_items' => $response['total_items']
        ]);
    }


    public function actionUpload()
    {
        $folder = Yii::$app->request->get('folder');
        $this->pageName = Yii::t('mailchimp/default', 'UPLOAD');
        if ($folder) {
            $responseFolder = Yii::$app->mailchimp->getClient()->get("file-manager/folders/{$folder}");
            $this->pageName = Yii::t('mailchimp/default', 'UPLOAD_TO', $responseFolder['name']);
        }

        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'FILE_MANAGER'),
            'url' => ['index']
        ];
        $this->breadcrumbs[] = $this->pageName;


        $model = new UploadFileForm();

        if (Yii::$app->request->isPost) {

            $tmpfile = UploadedFile::getInstance($model, 'file');
            $tmpfile_contents = file_get_contents($tmpfile->tempName);
            $model->file = base64_encode($tmpfile_contents);

            if ($folder) {
                $params['folder_id'] = $folder;
            }

            $params['name'] = $tmpfile->name;
            $params['file_data'] = $model->file;

            $response = Yii::$app->mailchimp->getClient()->post("file-manager/files", $params);

            //if ($response) {
            Yii::$app->session->setFlash('success', Yii::t('app/default', 'FILE_SUCCESS_UPLOAD', ['file' => $tmpfile->name]));
            // } else {
            //     Yii::$app->session->setFlash('error', Yii::t('app/default', 'FILE_ERROR_UPLOAD'));
            // }
            return $this->redirect(['index']);
        }


        return $this->render('upload', [
            'model' => $model,
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
