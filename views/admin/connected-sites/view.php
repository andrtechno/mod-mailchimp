<?php
use yii\helpers\Url;
use panix\engine\Html;
use panix\engine\CMS;

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

        <?php
        \panix\engine\CMS::dump($data);



        echo CMS::date(strtotime($data['send_time']));

        echo $data['settings']['reply_to'];
        echo $data['settings']['from_name'];
        echo $data['settings']['subject_line'];
        ?>
    </div>
</div>
