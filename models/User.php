<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users_usr".
 *
 * @property int $id_usr
 * @property string $nume_usr
 * @property string $prenume_usr
 * @property string $email_usr
 * @property string $parola_usr
 * @property string $datanastere_usr
 * @property string $sex_usr
 * @property string $tara_usr
 * @property string $oras_usr
 * @property string $authkey_usr
 * @property string $createdat_usr
 * @property string $lastlogin_usr
 * @property int $type_usr
 */
class User extends ActiveRecord implements IdentityInterface
{

    const TYPE_USER = 1;
    const TYPE_ADMINISTRATOR = 2;
    const TYPE_DISABLED = 3;


    public static function tableName()
    {
        return 'users_usr';
    }

    public function rules()
    {
        return [
            [['nume_usr', 'prenume_usr', 'email_usr', 'parola_usr', 'datanastere_usr'], 'required', 'on' => 'register', 'message' => 'Acest câmp este obligatoriu.'],
            [['nume_usr', 'prenume_usr', 'email_usr', 'datanastere_usr'], 'safe', 'on' => 'edit'],
            [['nume_usr', 'prenume_usr', 'email_usr', 'parola_usr', 'datanastere_usr', 'sex_usr', 'tara_usr', 'oras_usr'], 'string'],
            [['type_usr'], 'integer'],
            [['email_usr'], 'email', 'message' => 'Adresă email invalidă.'],
            [['email_usr'], 'unique', 'message' => 'Această adresă este deja utilizată.'],
            [['datanastere_usr'], 'match', 'pattern' => '#(19\d\d|20[0-1][0-9])-(0\d|1[0-2])-([0-2][0-9]|3[0-1])#', 'message' => 'Format invalid. Vă rugăm să scrieți data după cum urmeaza: yyyy-mm-dd'],
            [['sex_usr', 'tara_usr', 'oras_usr'], 'safe', 'on' => ['register', 'edit']],
        ];
    }

    public function validateID($attribute, $params, $validator)
    {
        if (Yii::$app->user->identity->id_usr != $this->$attribute) {
            $this->addError($attribute, 'You are not allowed to perform this action.');
            return false;
        }
        return true;
    }

    public function getCards()
    {
        return $this->hasMany(Card::className(), ['idusr_crd' => 'id_usr']);
    }

    /**
     * @return bool|void
     * @throws yii\base\Exception
     */
    public function beforeValidate()
    {
        if ($this->scenario == 'register') {
            $this->authkey_usr = yii::$app->security->generateRandomString(32);
            $this->type_usr = self::TYPE_USER;
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->scenario != 'register') {
            $this->lastlogin_usr = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    public function attributeLabels()
    {
        return [
            'id_usr' => 'Id',
            'nume_usr' => 'Nume',
            'prenume_usr' => 'Prenume',
            'email_usr' => 'Email',
            'parola_usr' => 'Parolă',
            'datanastere_usr' => 'Dată Naștere',
            'sex_usr' => 'Sex',
            'tara_usr' => 'Țară',
            'oras_usr' => 'Oraș',
            'tip_usr' => 'Tip',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['email_usr' => $username]);
    }

    public function getId()
    {
        return $this->id_usr;
    }

    public function getAuthKey()
    {
        return $this->authkey_usr;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authkey_usr === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->parola_usr);
    }
}
