<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['meta_keywords'] = 'Elite: Dangerous, market data, trade routes, outfitting, ships, engineers, galaxy information, stations, systems, material traders';
$this->title = 'EliteDa - Elite Dangerous Assistant';
?>

<main class="flex-grow-1 mb-4 bg-main-background">
    <div class="container-xxl px-3">
        <div class="row justify-content-evenly row-gap-4">
            <div class="d-flex justify-content-center mt-3">
                <div class="">
                    <h1 class="text-center mb-4 mt-3">
                        <?= 'Elite Dangerous Assistant' ?>
                    </h1>
                </div>
            </div>
            <div class="col-tile col-6 col-sm-4 row-gap-2 d-flex flex-column align-content-end">
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['commodities/index']) ?>">
                        Commodities
                    </a>
                </div>
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['trade-routes/index']) ?>">
                        Trade routes
                    </a>
                </div>
            </div>
            <div class="col-tile col-6 col-sm-4 row-gap-2 d-flex flex-column align-content-end">
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                        href="<?= Url::to(['engineers/index']) ?>">
                        Engineers
                    </a>
                </div>
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                        href="<?= Url::to(['material-traders/index']) ?>">
                        Material traders
                    </a>
                </div>
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                    justify-content-center"
                        href="<?= Url::to(['materials/index']) ?>">
                        Materials
                    </a>
                </div>
            </div>
            <div class="col-tile col-6 col-sm-4 row-gap-2 d-flex flex-column align-content-end">
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['shipyard-ships/index']) ?>">
                        Ships
                    </a>
                </div>
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['ship-modules/index']) ?>">
                        Ship modules
                    </a>
                </div>
            </div>
            <div class="col-tile col-6 col-sm-4 row-gap-2 d-flex flex-column align-content-end">
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['systems/index']) ?>">
                        Systems
                    </a>
                </div>
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['stations/index']) ?>">
                        Stations
                    </a>

                </div>
                <div class="main-tile gx-0 rounded-3">
                    <a class="nav-button sintony-bold h-100 btn btn-violet border-0 text-light d-flex flex-column
                            justify-content-center"
                        href="<?= Url::to(['rings/index']) ?>">
                        Rings
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>