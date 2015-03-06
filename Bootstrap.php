<?php

namespace yii3ds\shoppinglists;

use yii\base\BootstrapInterface;

/**
 * Products module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {

        // Add module URL rules.
        $app->getUrlManager()->addRules(
            [
                'POST <_m:shoppinglists>/<id:\d+>' => '<_m>/default/index',
                '<_m:shoppinglists>' => '<_m>/default/index',
                '<_m:shoppinglists>/<id:\d+>' => '<_m>/default/index',
                '<_m:shoppinglists>/<controller:\w+>' => '<_m>/<controller>/index',
                'POST <_m:shoppinglists>/<controller:\w+>' => '<_m>/<controller>/create',
            ]
        );
        // Add module I18N category.
        if (!isset($app->i18n->translations['yii3ds/shoppinglists']) && !isset($app->i18n->translations['yii3ds/*'])) {
            $app->i18n->translations['yii3ds/shoppinglists'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yii3ds/shoppinglists/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'yii3ds/shoppinglists' => 'shoppinglists.php',
                ]
            ];
        }
    }
}
