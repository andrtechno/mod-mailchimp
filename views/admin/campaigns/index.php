<?php
use yii\helpers\Url;
use panix\engine\Html;

/**
 * @var array $items
 * @var \yii\web\View $this
 */

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
                    <th class="text-center"><?= Yii::t('mailchimp/default','emails_sent') ?></th>
                    <th class="text-center"><?= Yii::t('mailchimp/default','content_type') ?></th>
                    <th class="text-center"><?= Yii::t('mailchimp/default','needs_block_refresh') ?></th>
                    <th class="text-center"><?= Yii::t('mailchimp/default','Campaign ID') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $data) { ?>
                    <tr>
                        <td class="text-center"><?= $data['emails_sent'] ?></td>
                        <td class="text-center"><?= $data['content_type'] ?></td>
                        <td class="text-center"><?= var_dump($data['needs_block_refresh']) ?></td>
                        <td class="text-center"><?= Html::a(Html::icon('search'),['view','id'=>$data['id']],['class'=>'btn btn-sm btn-outline-secondary']) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    </div>
</div>
