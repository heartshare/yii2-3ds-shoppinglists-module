<?php

namespace yii3ds\products\models;

use vova07\users\traits\ModuleTrait;
use yii\db\ActiveQuery;

/**
 * Class ProductQuery
 * @package yii3ds\event\models
 */
class ProductQuery extends ActiveQuery
{
    use ModuleTrait;

	public function resultOneThai()
    {
        $this->select('id , title_th AS title, price, price_special, thumb, image, link, created_at');

        return $this;
    }

    public function resultAllThai()
    {
    	$this->select('id , title_th AS title, price, price_special, thumb, image, link, created_at');

        return $this;
    }

    public function resultOneEnglish()
    {
        $this->select('id , title_en AS title, price, price_special, thumb, image, link, created_at');

        return $this;
    }

    public function resultAllEnglish()
    {
    	$this->select('id , title_en AS title, price, price_special, thumb, image, link, created_at');

        return $this;
    }    
}
