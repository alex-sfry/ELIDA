<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ar\ShipModulesList;

/**
 * ShipModulesListSearch represents the model behind the search form of `app\models\ar\ShipModulesList`.
 */
class ShipModulesListSearch extends ShipModulesList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'class'], 'integer'],
            [['symbol', 'name', 'mount', 'category', 'guidance', 'ship', 'rating', 'entitlement'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ShipModulesList::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'class' => $this->class,
        ]);

        $query->andFilterWhere(['like', 'symbol', $this->symbol])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mount', $this->mount])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'guidance', $this->guidance])
            ->andFilterWhere(['like', 'ship', $this->ship])
            ->andFilterWhere(['like', 'rating', $this->rating])
            ->andFilterWhere(['like', 'entitlement', $this->entitlement]);

        return $dataProvider;
    }
}
