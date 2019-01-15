<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "animals_anm".
 *
 * @property int $id_anm
 * @property string $denumire_anm
 *
 * @property Produs[] $produs
 */
class Animal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'animals_anm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denumire_anm'], 'required'],
            [['denumire_anm'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_anm' => 'ID',
            'denumire_anm' => 'Denumire Animal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdus()
    {
        return $this->hasMany(Produs::className(), ['idanm_prd' => 'id_anm']);
    }
}
