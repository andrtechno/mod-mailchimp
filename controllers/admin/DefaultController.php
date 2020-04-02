<?php

namespace panix\mod\mailchimp\controllers\admin;


use panix\engine\CMS;
use panix\engine\controllers\AdminController;
use RuntimeException;
use Exception;
use Yii;

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
    public function actionList()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $name = $request->get('name');
        $members = Yii::$app->mailchimp->getListMembers($id);

        $this->pageName = Yii::t('mailchimp/default', 'LISTS '.$name);
        $this->breadcrumbs[] = [
            'label' => Yii::t('mailchimp/default', 'MODULE_NAME'),
            'url' => ['/admin/mailchimp']
        ];
        $this->breadcrumbs[] = $this->pageName;

        return $this->render('list', [
            'members' => $members['members'],
            'id' => $id,
            'name' => $name
        ]);
    }
}
