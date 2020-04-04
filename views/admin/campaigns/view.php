<?php
use yii\helpers\Url;
use panix\engine\Html;
use panix\engine\CMS;

/**
 * @var array $response
 * @var \yii\web\View $this
 *
 */

?>
<div class="row">
    <div class="col-sm-6">

        <?php
        \panix\engine\CMS::dump($response);
        ?>
    </div>
    <div class="col-sm-6">

        <div class="card">
            <div class="card-header">
                <h5>tracking</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">

                    <tr>
                        <td class="text-left">opens</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['tracking']['opens']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">html_clicks</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['tracking']['html_clicks']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">text_clicks</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['tracking']['text_clicks']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">goal_tracking</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['tracking']['goal_tracking']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">ecomm360</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['tracking']['ecomm360']); ?></td>
                    </tr>


                    <tr>
                        <td class="text-left">google_analytics</td>
                        <td class="text-left"><?= Yii::$app->formatter->asNtext($response['tracking']['google_analytics']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">clicktale</td>
                        <td class="text-left"><?= $response['tracking']['clicktale']; ?></td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>settings</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <td class="text-left">subject_line</td>
                        <td class="text-left"><?= $response['settings']['subject_line']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">title</td>
                        <td class="text-left"><?= $response['settings']['title']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">from_name</td>
                        <td class="text-left"><?= $response['settings']['from_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">reply_to</td>
                        <td class="text-left"><?= $response['settings']['reply_to']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">use_conversation</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['use_conversation']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">to_name</td>
                        <td class="text-left"><?= $response['settings']['to_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">folder_id</td>
                        <td class="text-left"><?= $response['settings']['folder_id']; ?></td>
                    </tr>



                    <tr>
                        <td class="text-left">authenticate</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['authenticate']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">auto_footer</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['auto_footer']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">inline_css</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['inline_css']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">auto_tweet</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['auto_tweet']); ?></td>
                    </tr>


                    <tr>
                        <td class="text-left">fb_comments</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['fb_comments']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">timewarp</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['timewarp']); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">template_id</td>
                        <td class="text-left"><?= $response['settings']['template_id']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">drag_and_drop</td>
                        <td class="text-left"><?= Yii::$app->formatter->asBoolean($response['settings']['drag_and_drop']); ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>


