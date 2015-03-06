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
use yii3ds\products\models\backend\Category;
use vova07\fileapi\Widget as FileAPI;
use vova07\imperavi\Widget as Imperavi;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;



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
            <?= $form->field($model, 'price') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'price_special') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'link') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'category')->dropDownList(
                
                ArrayHelper::map(Category::find()->where(['active' => 1])->all(), 'id', 'title_th')
            ); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'image')->widget(
                FileAPI::className(),
                [
                    'settings' => [
                        'url' => ['/products/default/fileapi-upload']
                    ]
                ]
            ) ?>
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