<?php

/** @var yii\web\View $this */

use app\widgets\TableJs\TableJs;
use yii\helpers\Url;

use function app\helpers\d;
use function app\helpers\ksq;

$this->params['meta_keywords'] = 'Elite: Dangerous, galaxy information, station market, market information, commodities';

$this->title = $station_name . ' station  market';
$this->params['breadcrumbs'] = [
    [
        'label' => $station_name,
        'url' => ['stations/details', 'id' => $id],
    ],
    $this->title
];
?>
<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row">
            <div class="col mb-3">
                <h1 class='mt-3 text-center fs-2 sintony-bold'>
                    <?= $this->title ?>
                </h1>
                <div class="d-flex flex-column gap-2 justify-content-center justify-content-md-start mt-2">
                    <div class="d-flex gap-2 justify-content-center">

                        <!-- services side bar -->
                        <?= $this->render('_services', ['id' => $id, 'services' => $services, 'active' => 'market']) ?>
                        <!-- services side bar -->

                    </div>

                    <?= TableJs::widget([
                        'container' => 'w-table',
                        'model' => $model,
                        'default_sorting' => 'asc',
                        'columns' => [
                            [
                                'attribute' => 'buy_price',
                                'label' => 'buy price',
                                'textAfter' => ' Cr'
                            ],
                            [
                                'attribute' => 'demand',
                            ],
                            [
                                'attribute' => 'demand_bracket',
                                'label' => 'demand bracket',
                                'filter' => ['' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3'],
                                'filterInputOptions' => [
                                    'class' => 'form-select',
                                ],
                                'class' => 'text-center'
                            ],
                            [
                                'attribute' => 'mean_price',
                                'label' => 'mean price',
                            ],
                            [
                                'attribute' => 'name',
                                'label' => 'commodity',
                                'filterInputOptions' => [
                                    'class' => 'form-control',
                                ],
                                'req_url' => 'req_url',
                            ],
                            [
                                'attribute' => 'sell_price',
                                'label' => 'sell price',
                                'textAfter' => ' Cr'
                            ],
                            [
                                'attribute' => 'stock',
                            ],
                            [
                                'attribute' => 'stock_bracket',
                                'label' => 'stock bracket',
                                'filter' => ['' => '', '0' => '0', '1' => '1', '2' => '2', '3' => '3'],
                                'filterInputOptions' => [
                                    'class' => 'form-select',
                                ],
                                'class' => 'text-center'
                            ],
                            [
                                'attribute' => 'timestamp',
                                'label' => 'updated',
                            ],
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</main>