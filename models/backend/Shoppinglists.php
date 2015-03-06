<?php

namespace yii3ds\shoppinglists\models\backend;

use yii3ds\shoppinglists\Module;
use yii3ds\shoppinglists\components\Productcomponent;
use Yii;

/**
 * Class Product
 * @package yii3ds\shoppinglists\models\backend
 * Product model.
 *
* @property integer $id ID
 */
class Product extends \yii3ds\shoppinglists\models\Product
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_th', 'title_en', 'price_special', 'price'], 'required'],
            
            [['title_th', 'title_en', 'thumb', 'image', 'link'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_th' => 'Title Th',
            'title_en' => 'Title En',
            'price' => 'Price',
            'price_special' => 'Special Price',
            'image' => 'Image',
            'link' => 'Shop online url',
            'category' => 'Category',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['admin-create'] = [
            'title_th',
            'title_en',
            'price',
            'price_special',
            'image',
            'thumb',
            'link',
            'category',
            'created_at',
            'created_by',
        ];
        $scenarios['admin-update'] = [
            'title_th',
            'title_en',
            'price',
            'price_special',
            'image',
            'thumb',
            'link',
            'category',
            'created_at',
            'created_by',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $isUploadImage = !empty($this->image);
        if( $isUploadImage )
        {
            $productObject = new ProductComponent();   
            $filePath = Yii::getAlias($this->module->imagesTempPath  .  $this->image);
            $isFoundImage = file_exists($filePath);
            if( $isFoundImage )
            {
                $productObject->saveOriginalFile($filePath, $this->image);
                $this->thumb = $productObject->resizeImageThumbSize($filePath, $this->image);
                $this->image = $productObject->resizeImageFullsize($filePath, $this->image);
                unlink($filePath);    
            }
        }
        

        $this->created_by = Yii::$app->user->id;
        
        
        if (parent::beforeSave($insert)) {
            if( !$this->created_at) 
            {
                $this->created_at = date('Y-m-d H:i:s');        
            }
            return true;
        } else {
            
            return false;
        }
    }
}
