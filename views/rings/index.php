<?php

/** @var yii\web\View $this */

use app\assets\TSelectAsset;
use yii\helpers\Html;

use function app\helpers\d;

$this->title = 'Search for rings';
TSelectAsset::register($this);
// d($form_model->attributeLabels());
?>

<main class="flex-grow-1 bg-main-background d-flex flex-column justify-content-between sintony-reg">
    <div class='container-xxl'>
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-9 col-lg-8 col-xl-7">
                <div class='d-flex flex-column w-100 gap-3'>
                    <h1 class='mt-2 text-center fs-2 sintony-bold'><?= $this->title ?></h1>

<!-- accordion-form -->
<?= $this->render('_accordion', ['form_model' => $form_model, 'ref_error' => $ref_error]) ?>
<!-- end of accordion-form -->

                </div>
            </div>
        </div>
    </div>
</main>