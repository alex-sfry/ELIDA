<?php

use app\widgets\InputDropdown\InputDropdown;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

use function app\helpers\d;

$this->title = 'Search for stations';
$this->params['breadcrumbs'] = [$this->title];

$allegiance_options = [
    'Alliance' => 'Alliance',
    'Empire' => 'Empire',
    'Federation' => 'Federation',
    'Independent' => 'Independent',
    'None' => 'None',
    'Pirate' => 'Pirate',
    'unknown' => 'unknown'
];

$economy_options = [
    'Agriculture' => 'Agriculture',
    'Colony' => 'Colony',
    'Extraction' => 'Extraction',
    'High Tech' => 'High Tech',
    'Industrial' => 'Industrial',
    'Military' => 'Military',
    'None' => 'None',
    'Refinery' => 'Refinery',
    'Service' => 'Service',
    'Terraforming' => 'Terraforming',
    'Tourism' => 'Tourism',
    'Prison' => 'Prison',
    'Damaged' => 'Damaged',
    'Rescue' => 'Rescue',
    'Repair' => 'Repair',
    'Private Enterprise' => 'Private Enterprise',
    'Engineering' => 'Engineering',
    'unknown' => 'unknown'
];

$gov_options = [
    'Democracy' => 'Democracy',
    'Cooperative' => 'Cooperative',
    'Patronage' => 'Patronage',
    'Corporate' => 'Corporate',
    'Confederacy' => 'Confederacy',
    'Workshop (Engineer)' => 'Workshop (Engineer)',
    'Feudal' => 'Feudal',
    'Dictatorship' => 'Dictatorship',
    'Communism' => 'Communism',
    'Anarchy' => 'Anarchy',
    'Engineer' => 'Engineer',
    'Theocracy' => 'Theocracy',
    'Prison colony' => 'Prison colony',
];

$type_options = [
    'Ocellus Starport' => 'Ocellus Starport',
    'Orbis Starport' => 'Orbis Starport',
    'Outpost' => 'Outpost',
    'Coriolis Starport' => 'Coriolis Starport',
    'Planetary Outpost' => 'Planetary Outpost',
    'Asteroid base' => 'Asteroid base',
    'Planetary Port' => 'Planetary Port',
    'Odyssey Settlement' => 'Odyssey Settlement'
]

// isset($get) && d($get);
// d($refSysDist);
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='d-flex flex-column h-100'>
        <div class='container-xxl px-3'>
            <div class='row flex-column overflow-x-auto'>
                <div class='col'>
                    <h1 class="mt-2 text-center sintony-bold"><?= Html::encode($this->title) ?></h1>
                    <div class="mt-tr-ref-idd d-flex justify-content-end gap-2 flex-column flex-sm-row">
                        <div class="c-result-legend bg-light text-center rounded-2 py-1 h-50">
                            <h2 class="fs-6 position-relative d-inline-block">Station's type:</h2>
                            <div class="d-flex flex-column flex-sm-row align-items-center py-1 ps-2 pe-1 row-gap-1">
                                <div class="c-result-legend-item d-flex justify-content-start w-100 column-gap-1 
                                            pe-1 align-items-center text-nowrap">
                                    <div class="c-result-legend-item-color bg-success h-100"></div>
                                    - surface
                                </div>
                                <div class="c-result-legend-item d-flex justify-content-start w-100 column-gap-1 
                                            align-items-center text-nowrap">
                                    <div class="c-result-legend-item-color bg-primary ms-0 ms-sm-2 h-100"></div>
                                    - space
                                </div>
                            </div>
                        </div>
                        <?= Html::beginForm(['/stations/index'], 'get', [
                            'id' => 'mt-form',
                            'class' => 'bg-light p-1 rounded-2',
                            'novalidate' => true,
                        ]) ?>
                        <div class="row gx-2">
                            <div class="col-6" style='max-width: 160px;'>
                                <?= Html::label(
                                    'Max. distance (LY):',
                                    'maxDistance',
                                    ['class' => 'min-lett-spacing fw-bold']
                                ); ?>
                                <div class="search-selected info bg-info px-1 py-1 lh-1 rounded-2">
                                    <?= $form['max_distance']; ?>
                                </div>
                                <?= Html::textInput(
                                    'maxDistance',
                                    '',
                                    [
                                        'id' => 'maxDistance',
                                        'class' => 'form-control shadow-none border border-dark rounded-2 p-1',
                                        'style' => 'min-width: 140px;max-width: 160px;margin-top:0.125rem;'
                                    ]
                                ); ?>
                            </div>
                            <div class="grid-view__ref-sys-divider bg-dark p-0 opacity-50"
                                style="width:2px;max-height:100%"></div>
                            <div class="col-6" style='min-width: 240px;max-width: 240px'>
                                <?= InputDropdown::widget([
                                    'container' => 'mt-tr-ref-idd',
                                    'selected' => $form['system'],
                                    'search' => 'ref-idd-search',
                                    'to_submit' => 'ref-to-submit',
                                    'placeholder' => 'Enter system',
                                    'ajax' => true,
                                    'endpoint' => '/system/get/',
                                    'label_main' => 'Ref. system:',
                                    'toggle_btn_text' => 'Search',
                                    'name_main' => 'refSysStation',
                                    'required' => 'required',
                                    'btn_position' => 'right'
                                ]); ?>
                            </div>
                        </div>
                        <button class="btn btn-violet btn-sm mt-2 lett-spacing-2">submit</button>
                        <?php echo Html::endForm() ?>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'headerRowOptions' => [
                            'class' => 'text-nowrap align-middle'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'station',
                                'label' => 'Station',
                                'value' => function ($model) {
                                    $id = (int)$model->id;
                                    return Html::a(
                                        Html::encode($model->station),
                                        Url::toRoute(["station/$id"]),
                                        ['class' => [
                                            'text-decoration-underline',
                                            'link-underline-primary',
                                            'table-link'
                                            ]
                                        ]
                                    );
                                },
                                'format' => 'raw',
                                'filterInputOptions' => [
                                    'class' => 'form-control form-control-sm',
                                ]
                            ],
                            [
                                'attribute' => 'type',
                                'label' => 'Type',
                                'value' => function ($model) {
                                    $pad = '';
                                    $type = Html::encode($model->type);
                                    $color = in_array(
                                        $type,
                                        ['Planetary Outpost', 'Planetary Port', 'Odyssey Settlement']
                                    ) ? 'text-success' : 'text-primary';
                                    ;
                                    if ($type !== 'Outpost' && $type !== 'Odyssey Settlement') {
                                        $pad = 'L';
                                    } elseif ($type === 'Outpost') {
                                        $pad = 'M';
                                    } elseif ($type === 'Odyssey Settlement') {
                                        $pad = 'S or L';
                                    }
                                    return "
                                    <span class='text-nowrap sintony-bold $color'>
                                        $type
                                        <span class='badge rounded-pill bg-primary'>$pad</span>
                                    </span>
                                    ";
                                },
                                'format' => 'raw',
                                'filter' => $type_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
                            [
                                'attribute' => 'distance_to_arrival',
                                'label' => 'Dist. to arrival (ls)',
                            ],
                            [
                                'attribute' => 'distance',
                                'label' => 'Distance (LY)',
                                'value' => function ($model) {
                                    return (float)$model->distance;
                                }
                            ],
                            [
                                'attribute' => 'government',
                                'label' => 'Government',
                                'filter' => $gov_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
                            [
                                'attribute' => 'economy_name',
                                'label' => 'Economy (main)',
                                'filter' => $economy_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
                            [
                                'attribute' => 'allegiance',
                                'label' => 'Allegiance',
                                'filter' => $allegiance_options,
                                'filterInputOptions' => [
                                    'class' => 'form-select form-select-sm',
                                ]
                            ],
                            [
                                'attribute' => 'system',
                                'label' => 'System',
                                'value' => function ($model) {
                                    $id = (int)$model->system_id;
                                    return Html::a(
                                        Html::encode($model->system),
                                        Url::toRoute(["system/$id"]),
                                        ['class' => [
                                            'text-decoration-underline',
                                            'link-underline-primary',
                                            'table-link'
                                            ]
                                        ]
                                    );
                                },
                                'format' => 'raw',
                                'filterInputOptions' => [
                                    'class' => 'form-control form-control-sm',
                                ]
                            ],
                        ],
                        'pager' => [
                            'class' => 'yii\bootstrap5\LinkPager',
                            'firstPageLabel' => 'first',
                            'lastPageLabel' => 'last',
                            'prevPageCssClass' => 'prev-page',
                            'nextPageCssClass' => 'next-page',
                            'options' => [
                                'class' => 'd-flex justify-content-center'
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</main>