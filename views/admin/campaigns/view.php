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
<?= Html::beginForm(); ?>
<?php echo Html::submitButton('Отправить тестовое письмо',['name'=>'send_test','value'=>'1','class'=>'btn btn-success']); ?>
<?php if($response['status'] == 'save'){ ?>
<?php echo Html::submitButton('Начать отправку подписчикам',['name'=>'send','value'=>'1','class'=>'btn btn-success']); ?>
    <?php } ?>
<?php Html::endForm(); ?>
<div class="row">
    <div class="col-sm-6">
        <?php if($response['status'] != 'save' && isset($response['report_summary'])){ ?>
        <div class="card">
            <div class="card-header">
                <h5>Reports</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <td class="text-left">opens</td>
                        <td colspan="2" class="text-left"><?= $response['report_summary']['opens']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">unique_opens</td>
                        <td colspan="2" class="text-left"><?= $response['report_summary']['unique_opens']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">open_rate</td>
                        <td colspan="2" class="text-left"><?= $response['report_summary']['open_rate']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">clicks</td>
                        <td colspan="2" class="text-left"><?= $response['report_summary']['clicks']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">subscriber_clicks</td>
                        <td colspan="2" class="text-left"><?= $response['report_summary']['subscriber_clicks']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left">click_rate</td>
                        <td colspan="2" class="text-left"><?= $response['report_summary']['click_rate']; ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-center">E-commerce</th>
                    </tr>
                    <tr>
                        <th class="text-center">Всего заказов</th>
                        <th class="text-center">Всего потрачено</th>
                        <th class="text-center">Общий доход</th>
                    </tr>
                    <tr>
                        <td class="text-center"><?= $response['report_summary']['ecommerce']['total_orders']; ?></td>
                        <td class="text-center"><?= $response['report_summary']['ecommerce']['total_spent']; ?></td>
                        <td class="text-center"><?= $response['report_summary']['ecommerce']['total_revenue']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php } ?>
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
<?php
$responseReport = Yii::$app->mailchimp->getClient()->get("reports/{$id}");

//CMS::dump($responseReport);die;

//$responseReport2 = Yii::$app->mailchimp->getClient()->get("reports/{$id}/locations");
//CMS::dump($responseReport2);die;
$highchartsData=[];
$highchartsData2=[];
$highchartsCategories=[];
//sort($responseReport['timeseries']);
foreach ($responseReport['timeseries'] as $timeline){
    $highchartsCategories[]=date('H:i',strtotime($timeline['timestamp']));
    $highchartsData[]=$timeline['emails_sent'];
    $highchartsData2[]=$timeline['unique_opens'];
}



//CMS::dump($highchartsCategories);die;
echo \panix\ext\highcharts\Highcharts::widget([
    'scripts' => [
        // 'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
        'modules/exporting',
        //'modules/drilldown',
    ],
    'options' => [
        'chart' => [
            'type' => 'column',
            'plotBackgroundColor' => null,
            'plotBorderWidth' => null,
            'plotShadow' => false,
            'backgroundColor' => 'rgba(255, 255, 255, 0)'
        ],
        'title' => ['text' => 'timeline'],
        'xAxis' => [
            'type' => 'category',
            //'categories' => range(1, cal_days_in_month(CAL_GREGORIAN, $month, $year))
            'categories' => $highchartsCategories
        ],
        'yAxis' => [
            'title' => ['text' => 'Сумма']
        ],

        'legend' => [
            'enabled' => false
        ],
        'plotOptions' => [
            'areaspline' => [
                'fillOpacity' => 0.5
            ],
            'area' => [
                'pointStart' => 1940,
                'marker' => [
                    'enabled' => false,
                    'symbol' => 'circle',
                    'radius' => 2,
                    'states' => [
                        'hover' => [
                            'enabled' => true
                        ]
                    ]
                ]
            ],
            'series' => [
                'borderWidth' => 0,
                'dataLabels' => [
                    'enabled' => true,
                    'format' => '{point.y:.1f}%'
                ]
            ]
        ],
        // 'tooltip' => array(
        //     'shared' => true,
        //     'valueSuffix' => ' кол.'
        // ),
        'tooltip' => [
            'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
            'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        ],
        'series' => [
            // array('name' => 'Сумма заказов', 'data' => $data_total),
            //array('name' => 'Заказы', 'data' => $data),
            [
                'name' => 'Clicns',
                'colorByPoint' => true,
                'tooltip' => [
                    'pointFormat' => '<span style="font-weight: bold; color: {series.color}">{series.name}</span>: {point.value}<br/><b>Продано товаров: {point.products}<br/>{point.total_price}</b>' // {point.y:.1f}
                ],
                'data' => $highchartsData
            ],
            /*[
                'name' => 'test',
                'colorByPoint' => true,
                'tooltip' => [
                    'pointFormat' => '<span style="font-weight: bold; color: {series.color}">{series.name}</span>: {point.value}<br/><b>Продано товаров: {point.products}<br/>{point.total_price}</b>' // {point.y:.1f}
                ],
                'data' => $highchartsData2
            ],*/
        ],

        /*"drilldown" => [
            'activeDataLabelStyle' => [
                'color' => '#ea5510',//'#343a40',
                'cursor' => 'pointer',
                'fontWeight' => 'bold',
                'textDecoration' => 'none',
            ],
            "series" => $highchartsDrill
        ]*/
    ]
]);