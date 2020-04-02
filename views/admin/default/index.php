<?php

/** @var array $items */

// Set Title and Breadcrumbs
$this->title = Yii::t('mailchimp/default', 'Lists');
$this->params['breadcrumbs'][] = Yii::t('mailchimp/default', 'Newsletters');
$this->params['breadcrumbs'][] = $this->title;

?>
<?php

/** @var array $lists */

use yii\helpers\Url;

?>
<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName; ?></h5>
    </div>
    <div class="card-body">
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table">
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
    </div>
</div>