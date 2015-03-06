<?php

use yii\db\Schema;
use yii\db\Migration;

class m150305_120511_products extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable('{{%products}}',
        [
                'id'=> Schema::TYPE_PK.'',
                'title_th'=> Schema::TYPE_STRING.'(150) NOT NULL',
                'title_en'=> Schema::TYPE_STRING.'(150) NOT NULL',
                'price'=> Schema::TYPE_DECIMAL.'(18,2) NOT NULL',
                'price_special'=> Schema::TYPE_DECIMAL.'(18,2) NOT NULL',
                'thumb'=> Schema::TYPE_TEXT.' NOT NULL',
                'image'=> Schema::TYPE_TEXT.' NOT NULL',
                'link'=> Schema::TYPE_TEXT.' NOT NULL',
                'category'=> Schema::TYPE_INTEGER.'(11) NOT NULL',
                'created_at'=> Schema::TYPE_DATETIME.' NOT NULL',
                'created_by'=> Schema::TYPE_INTEGER.'(11) NOT NULL',
                'deleted'=> Schema::TYPE_BOOLEAN.'(1) NOT NULL',
                ], $tableOptions);

                 
    }

    public function safeDown()
    {

                    $this->dropTable('{{%products}}');
    }
}
