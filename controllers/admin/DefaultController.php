<?php


namespace panix\mod\mailchimp\controllers\admin;

use Exception;
use panix\engine\controllers\AdminController;
use RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

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
    public function actionLists()
    {
	    $lists = Yii::$app->mailchimp->getLists();

        return $this->render('lists', [
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

    public function actionCampaign()
    {
        $data = Yii::$app->mailchimp->getCampaignFolders();

        return $this->render('campaigns', [
            'items' => $data['folders'],
        ]);
    }
}
