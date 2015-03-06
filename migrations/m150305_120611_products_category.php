<?php

use yii\db\Schema;
use yii\db\Migration;

class m150305_120611_products_category extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%products_category}}',
        [
                'id'=> Schema::TYPE_PK.'',
                'title_th'=> Schema::TYPE_STRING.'(150) NOT NULL',
                'title_en'=> Schema::TYPE_STRING.'(150) NOT NULL',
                'active'=> Schema::TYPE_BOOLEAN.'(1) NOT NULL',
                'sort'=> Schema::TYPE_INTEGER.'(11) NOT NULL',
                'created_at'=> Schema::TYPE_DATETIME.' NOT NULL',
                'created_by'=> Schema::TYPE_INTEGER.'(11) NOT NULL',
                ], $tableOptions);

                 
    }

    public function safeDown()
    {

                    $this->dropTable('{{%products_category}}');
    }
}
