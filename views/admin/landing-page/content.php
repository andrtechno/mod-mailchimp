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
        <?php //echo $response['html']; ?>
        <?php
       // \panix\engine\CMS::dump($response['html']);



        ?>
        <iframe>
            <?= $response['html']; ?>
        </iframe>
    </div>
</div>
