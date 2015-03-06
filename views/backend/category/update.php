<?php

/**
 * Product update view.
 *
 * @var yii\base\View $this View
 * @var yii3ds\products\models\backend\Product $model Model
 * @var \yii3ds\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use yii3ds\themes\admin\widgets\Box;
use yii3ds\products\Module;

$this->title = Module::t('products', 'BACKEND_UPDATE_TITLE');
$this->params['subtitle'] = Module::t('products', 'BACKEND_UPDATE_SUBTITLE');
$this->params['breadcrumbs'] = [
    [
        'label' => $this->title,
        'url' => ['index'],
    ],
    $this->params['subtitle']
];
$boxButtons = ['{cancel}'];

if (Yii::$app->user->can('BCreateProducts')) {
    $boxButtons[] = '{create}';
}
if (Yii::$app->user->can('BDeleteProducts')) {
    $boxButtons[] = '{delete}';
}
$boxButtons = !empty($boxButtons) ? implode(' ', $boxButtons) : null; ?>
<div class="row">
    <div class="col-sm-12">
        <?php $box = Box::begin(
            [
                'title' => $this->params['subtitle'],
                'renderBody' => false,
                'options' => [
                    'class' => 'box-success'
                ],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => $boxButtons
            ]
        );
        echo $this->render(
            '_form',
            [
                'model' => $model,
                // 'statusArray' => $statusArray,
                'box' => $box
            ]
        );
        Box::end(); ?>
    </div>
</div>
