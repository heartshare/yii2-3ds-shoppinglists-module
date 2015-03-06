<?php

/**
 * Product form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \yii3ds\products\models\backend\Product $model Model
 * @var \yii3ds\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use yii3ds\products\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;



?>
<?php $form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title_th') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title_en') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
                $isActiveNoValue = !isset($model->active);
                if( $isActiveNoValue )
                {
                    $model->active = true;    
                }
                
                echo $form->field($model, 'active')->widget(SwitchInput::classname(), 
                [
                    'type' => SwitchInput::CHECKBOX,
                    'value'=> true
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php 
                $isSortNoValue = !isset( $model->sort );
                if ($isSortNoValue)
                {
                    $model->sort = 1;    
                }
                echo $form->field($model, 'sort');

            ?>
        </div>
    </div>
    
    
    
   
    
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('products', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'products',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>