<?php

namespace yii3ds\shoppinglists\traits;

use yii3ds\shoppinglists\Module;

/**
 * Class ModuleTrait
 * @package yii3ds\shoppinglists\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait
{
    /**
     * @var \yii3ds\shoppinglists\Module|null Module instance
     */
    private $_module;

    /**
     * @return \yii3ds\shoppinglists\Module|null Module instance
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Module::getInstance();
        }
        return $this->_module;
    }
}
