<?php


namespace panix\mod\mailchimp\controllers;

use Exception;
use RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['lists', 'list'],
                        'roles' => $this->module->roles
                    ]
                ],
                'denyCallback' => static function () {
	                throw new RuntimeException(Yii::t('traits','You are not allowed to access this page'));
                }
            ]
        ];
    }

	/**
	 * Displays Lists view
	 *
	 * @return mixed
	 * @throws Exception
	 */
    public function actionLists()
    {
	    $lists = Yii::$app->mailchimp->getLists();

        return $this->render('lists', [
            'lists' => $lists['lists'],
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
        $request  = Yii::$app->request;
	    $listID   = $request->get('id');
        $listName = $request->get('name');
        $members  = Yii::$app->mailchimp->getListMembers($listID);

        return $this->render('list', [
            'members' => $members['members'],
            'id' => $listID,
            'name' => $listName
        ]);
    }
}
