
<?php

namespace yii3ds\shoppinglists\models\backend;

use yii\data\ActiveDataProvider;

/**
 * Product search model.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Integer
            ['id', 'integer'],
            // String
            [['title_th', 'title_en'], 'string', 'max' => 255],
            // Date
            [['created_at'], 'date', 'format' => 'd.m.Y']
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider DataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at,
            ]
        );
        
        return $dataProvider;
    }
}
