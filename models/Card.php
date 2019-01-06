<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cards_crd".
 *
 * @property int $id_crd
 * @property int $idusr_crd
 * @property string $serial_crd
 * @property string $holder_crd
 * @property string $expiration_crd
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cards_crd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idusr_crd'], 'integer'],
            [['serial_crd'], 'string', 'max' => 20],
            [['serial_crd'], 'unique'],
            [['holder_crd'], 'string', 'max' => 30],
            [['expiration_crd'], 'string', 'max' => 10],
            [['serial_crd', 'holder_crd', 'expiration_crd', 'secret_crd'], 'required', 'on' => 'add', 'message' => 'Acest câmp este obligatoriu!'],
            [['idusr_crd', 'serial_crd', 'holder_crd', 'expiration_crd', 'secret_crd'], 'safe', 'on' => 'edit'],
            [['serial_crd'], 'match', 'pattern' => '#\d{4}-\d{4}-\d{4}-\d{4}#', 'message' => 'Seria cardului trebuie să fie de forma 1111-2222-3333-4444.'],
            [['holder_crd'], 'match', 'pattern' => '#[A-Z]+#', 'message' => 'Nume invalid!', 'on' => 'add'],
            [['expiration_crd'], 'match', 'pattern' => '#[0-1][0-9]-[1-2][0-9]#', 'message' => 'Data expirării trebuie să fie de forma LL-AA.'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_crd' => 'ID',
            'idusr_crd' => 'ID User',
            'serial_crd' => 'Seria Cardului',
            'holder_crd' => 'Nume Deținător',
            'expiration_crd' => 'Data expirării',
        ];
    }
}
