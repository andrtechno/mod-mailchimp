<?php
use yii\helpers\Url;
/** @var array $lists */

// Set Title and Breadcrumbs
$this->title = Yii::t('mailchimp/default', 'Lists');
$this->params['breadcrumbs'][] = Yii::t('mailchimp/default', 'Newsletters');
$this->params['breadcrumbs'][] = $this->title;

print_r($items);die;
?>


<div class="row">

    <div class="col-md-12">

        <div class="table-responsive">

            <table class="table no-margin">
                <thead>
                <tr>
                    <th class="text-center"><?= Yii::t('mailchimp/default','List Name') ?></th>
                    <th class="text-center"><?= Yii::t('mailchimp/default','Member Count') ?></th>
                    <th class="text-center"><?= Yii::t('mailchimp/default','Unsubscribe Count') ?></th>
                    <th class="text-center"><?= Yii::t('mailchimp/default','ID') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $list) {

                    $list_id = $list['id'];
                    $list_name = '<a href="'.Url::to([ 'list', 'id' => $list['id'], 'name' => $list['name'] ]).'">'.$list['name'].'</a>';
                    $member_count = $list['stats']['member_count'];
                    $member_unsub = $list['stats']['unsubscribe_count'];

                    ?>
                    <tr>
                        <td class="text-center"><?= $list_name ?></td>
                        <td class="text-center"><?= $member_count ?></td>
                        <td class="text-center"><?= $member_unsub ?></td>
                        <td class="text-center"><?= $list_id ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>

    </div>

</div>

