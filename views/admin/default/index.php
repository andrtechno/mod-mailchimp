<?php

/** @var array $items */

use yii\helpers\Url;
use panix\engine\Html;

?>
<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName; ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"><?= Yii::t('mailchimp/default', 'List Name') ?></th>
                            <th class="text-center"><?= Yii::t('mailchimp/default', 'Member Count') ?></th>
                            <th class="text-center"><?= Yii::t('mailchimp/default', 'Unsubscribe Count') ?></th>
                            <th class="text-center"><?= Yii::t('app/default', 'OPTIONS') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $list) {

                           // \panix\engine\CMS::dump($list);
                            $member_count = $list['stats']['member_count'];
                            $member_unsub = $list['stats']['unsubscribe_count'];

                            ?>
                            <tr>
                                <td class="text-center"><?= $list['name'] ?></td>
                                <td class="text-center"><?= $member_count ?></td>
                                <td class="text-center"><?= $member_unsub ?></td>
                                <td class="text-center"><?= Html::a(Html::icon('search'), ['view', 'id' => $list['id'], 'name' => $list['name']], ['class' => 'btn btn-sm btn-outline-secondary']); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
