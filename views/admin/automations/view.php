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

        <?php
        \panix\engine\CMS::dump($data);
        ?>
    </div>
</div>
