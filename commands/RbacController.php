<?php

namespace yii3ds\shoppinglists\commands;

use Yii;
use yii\console\Controller;

/**
 * shoppinglists RBAC controller.
 */
class RbacController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'add';

    /**
     * @var array Main module permission array
     */
    public $mainPermission = [
        'name' => 'administrateshoppinglists',
        'description' => 'Can administrate all "shoppinglists" module'
    ];

    /**
     * @var array Permission
     */
    public $permissions = [
        'BViewshoppinglists' => [
            'description' => 'Can view backend shoppinglists list'
        ],
        'BCreateshoppinglists' => [
            'description' => 'Can create backend shoppinglists'
        ],
        'BUpdateshoppinglists' => [
            'description' => 'Can update backend shoppinglists'
        ],
        'BDeleteshoppinglists' => [
            'description' => 'Can delete backend shoppinglists'
        ],
        'viewshoppinglists' => [
            'description' => 'Can view shoppinglists'
        ],
        'createshoppinglists' => [
            'description' => 'Can create shoppinglists'
        ],
        'updateshoppinglists' => [
            'description' => 'Can update shoppinglists'
        ],
        'updateOwnshoppinglists' => [
            'description' => 'Can update own shoppinglists',
            'rule' => 'author'
        ],
        'deleteshoppinglists' => [
            'description' => 'Can delete shoppinglists'
        ],
        'deleteOwnshoppinglists' => [
            'description' => 'Can delete own shoppinglists',
            'rule' => 'author'
        ]
    ];

    /**
     * Add comments RBAC.
     */
    public function actionAdd()
    {
        $auth = Yii::$app->authManager;
        $superadmin = $auth->getRole('superadmin');
        $mainPermission = $auth->createPermission($this->mainPermission['name']);
        if (isset($this->mainPermission['description'])) {
            $mainPermission->description = $this->mainPermission['description'];
        }
        if (isset($this->mainPermission['rule'])) {
            $mainPermission->ruleName = $this->mainPermission['rule'];
        }
        $auth->add($mainPermission);

        foreach ($this->permissions as $name => $option) {
            $permission = $auth->createPermission($name);
            if (isset($option['description'])) {
                $permission->description = $option['description'];
            }
            if (isset($option['rule'])) {
                $permission->ruleName = $option['rule'];
            }
            $auth->add($permission);
            $auth->addChild($mainPermission, $permission);
        }

        $auth->addChild($superadmin, $mainPermission);

        $updateshoppinglists = $auth->getPermission('updateshoppinglists');
        $updateOwnshoppinglists = $auth->getPermission('updateOwnshoppinglists');
        $deleteshoppinglists = $auth->getPermission('deleteshoppinglists');
        $deleteOwnshoppinglists = $auth->getPermission('deleteOwnshoppinglists');

        $auth->addChild($updateshoppinglists, $updateOwnshoppinglists);
        $auth->addChild($deleteshoppinglists, $deleteOwnshoppinglists);

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * Remove comments RBAC.
     */
    public function actionRemove()
    {
        $auth = Yii::$app->authManager;
        $permissions = array_keys($this->permissions);

        foreach ($permissions as $name => $option) {
            $permission = $auth->getPermission($name);
            $auth->remove($permission);
        }

        $mainPermission = $auth->getPermission($this->mainPermission['name']);
        $auth->remove($mainPermission);

        return static::EXIT_CODE_NORMAL;
    }
}
