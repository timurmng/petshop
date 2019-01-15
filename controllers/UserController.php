<?php

namespace app\controllers;

use app\components\AccessRule;
use app\models\Card;
use yii;
use app\models\User;
use yii\web\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => yii\filters\AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['admin', 'view', 'edit', 'delete', 'register'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['admin', 'view', 'edit', 'delete'],
                        'roles' => [User::TYPE_ADMINISTRATOR]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'delete'],
                        'roles' => [User::TYPE_USER]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register'],
                        'roles' => ['?']
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $emai
     * @throws yii\db\Exception
     */
    public function actionView()
    {
        $user = User::findOne(['email_usr' => yii::$app->user->identity->email_usr]);
        if ($user->cards) {
            $command = yii::$app->db->createCommand("SELECT * FROM " . User::tableName() . " as u
            INNER JOIN " . Card::tableName() . " as c ON u.id_usr = c.idusr_crd
            INNER JOIN user_type as t ON u.type_usr = t.id_type  
            WHERE email_usr = :email")
                ->bindValue(':email', yii::$app->user->identity->email_usr);
        } else {
            $command = yii::$app->db->createCommand("SELECT * FROM " . User::tableName() . " as u
            INNER JOIN user_type as t ON u.type_usr = t.id_type  
            WHERE email_usr = :email")
                ->bindValue(':email', Yii::$app->user->identity->email_usr);
        }

        $comanda = json_encode($command->getRawSql(), JSON_PRETTY_PRINT);
        $model = $command->queryAll(\PDO::FETCH_ASSOC);

        return $this->render('view', [
            'model' => $model,
            'comanda' => $comanda,
            'user' => $user
        ]);
    }

    /**
     * @throws yii\base\Exception
     */
    public function actionRegister()
    {
        $model = new User(['scenario' => 'register']);
        $command = '';
        if ($model->load(Yii::$app->request->post())) {
            $model->parola_usr = yii::$app->security->generatePasswordHash($model->parola_usr);
            if ($model->validate()) {
                $command = yii::$app->db->createCommand(
                    "INSERT INTO " . User::tableName() .
                    "(`nume_usr`, `prenume_usr`, `email_usr`, `parola_usr`, `datanastere_usr`, `sex_usr`, `tara_usr`, `oras_usr`, `authkey_usr`, `type_usr`) 
                    VALUES(:nume_usr, :prenume_usr, :email_usr, :parola_usr, :datanastere_usr, :sex_usr, :tara_usr, :oras_usr, :authkey_usr, :type_usr)")
                    ->bindValues([
                        ':nume_usr' => $model->nume_usr,
                        ':prenume_usr' => $model->prenume_usr,
                        ':email_usr' => $model->email_usr,
                        ':parola_usr' => $model->parola_usr,
                        ':datanastere_usr' => $model->datanastere_usr,
                        ':sex_usr' => $model->sex_usr,
                        ':tara_usr' => $model->tara_usr,
                        ':oras_usr' => $model->oras_usr,
                        ':authkey_usr' => $model->authkey_usr,
                        ':type_usr' => $model->type_usr,
                    ]);
                $comanda = json_encode($command->getRawSql(), JSON_PRETTY_PRINT);
                $command->execute();
                yii::$app->session->setFlash('success', 'Felicitări, te-ai înregistrat cu succes! Acum te poți loga liniștit');
                yii::$app->session->setFlash('warning', $comanda);
                return $this->redirect('/user/view');
            }
        }

        return $this->render('register', [
            'model' => $model,
            'command' => $command,
        ]);
    }

    /**
     * @throws yii\db\Exception
     * @throws yii\base\Exception
     */
    public function actionEdit()
    {
        $model = User::findOne(['email_usr' => Yii::$app->user->identity->email_usr]);
        $model->setScenario('edit');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->parola_usr != '') {
                $model->parola_usr = yii::$app->security->generatePasswordHash($model->parola_usr);
            }
            $command = Yii::$app->db->createCommand("UPDATE " . User::tableName() . " 
                    SET nume_usr = :nume_usr,
                        prenume_usr = :prenume_usr,
                        email_usr = :email_usr,
                        parola_usr = :parola_usr,
                        datanastere_usr = :datanastere_usr,
                        sex_usr = :sex_usr,
                        tara_usr = :tara_usr,
                        oras_usr = :oras_usr,
                        authkey_usr = :authkey_usr,
                        lastlogin_usr = :lastlogin_usr,
                        type_usr = :type_usr
                    WHERE email_usr = '" . Yii::$app->user->identity->email_usr . "'"
            )->bindValues([
                ':nume_usr' => $model->nume_usr,
                ':prenume_usr' => $model->prenume_usr,
                ":email_usr" => $model->email_usr,
                ":parola_usr" => $model->parola_usr,
                ":datanastere_usr" => $model->datanastere_usr,
                ":sex_usr" => $model->sex_usr,
                ":tara_usr" => $model->tara_usr,
                ":oras_usr" => $model->oras_usr,
                ":authkey_usr" => $model->authkey_usr,
                ":lastlogin_usr" => $model->lastlogin_usr,
                ":type_usr" => $model->type_usr,
            ]);
            $comanda = $command->getRawSql();
            $command->execute();
            yii::$app->session->setFlash('success', 'Profilul dumneavoastră a fost modificat cu succes!');
            yii::$app->session->setFlash('warning', $comanda);
            return $this->redirect('/user/view');
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * @param $email
     * @throws yii\db\Exception
     */
    public function actionDelete($email)
    {
        $command = yii::$app->db->createCommand("DELETE FROM " . User::tableName() . "
            WHERE email_usr = :email_usr")
            ->bindValue(':email_usr', $email);
        $comanda = $command->getRawSql();
        $command->execute();
        yii::$app->session->setFlash('danger', 'Utilizator șters cu succes!');
        yii::$app->session->setFlash('warning', $comanda);
        yii::$app->session->close();
        return $this->redirect('/site/index');
    }
}