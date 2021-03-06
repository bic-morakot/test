<?php

namespace app\modules\resource\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\resource\models\ResUsers;

/**
 * ResUsersSearch represents the model behind the search form about `app\modules\resource\models\ResUsers`.
 */
class ResUsersSearch extends ResUsers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'id_card', 'create_uid', 'write_uid'], 'integer'],
            [['username', 'email', 'firstname', 'lastname', 'create_date', 'write_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = ResUsers::find();

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
            'active' => $this->active,
            'id_card' => $this->id_card,
            
            'create_uid' => $this->create_uid,
            'create_date' => $this->create_date,
            'write_uid' => $this->write_uid,
            'write_date' => $this->write_date,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname]);

        return $dataProvider;
    }
}
