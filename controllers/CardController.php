<?php
/**
 * Created by PhpStorm.
 * User: timurmengazi
 * Date: 03.12.2018
 * Time: 13:15
 */

namespace app\controllers;


use app\models\Card;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\Controller;
use yii;

class CardController extends Controller
{

    // Definirea accesului in cadrul controller-ului pentru carduri
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['admin', 'view', 'edit', 'delete', 'add'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['admin', 'view', 'edit', 'add', 'delete'],
                        'roles' => [User::TYPE_ADMINISTRATOR]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add', 'view', ' delete', 'edit']
                    ]
                ],
            ],
        ];
    }


    // Backend adaugare card
    /**
     * @throws yii\db\Exception
     */
    public function actionAdd()
    {
        $model = new Card(['scenario' => 'add']);
        // Daca request-ul este trimis catre server & inputurile sunt validate
        // inseram in baza de date & redirectionam cu mesaj de succes + query-ul rulat efectiv
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $command = yii::$app->db->createCommand("INSERT INTO " . Card::tableName() . " (`idusr_crd`, `serial_crd`, `holder_crd`, `expiration_crd`)  
            VALUES (:idusr_crd, :serial_crd, :holder_crd, :expiration_crd)")
                ->bindValues([
                    ':idusr_crd' => yii::$app->user->identity->id_usr,
                    ':serial_crd' => $model->serial_crd,
                    ':holder_crd' => strtoupper($model->holder_crd),
                    ':expiration_crd' => $model->expiration_crd,
                ]);

            $comanda = $command->getRawSql();
            $command->execute();

            yii::$app->session->setFlash('success', 'Felicitări, cardul a fost adăugat cu succes!');
            yii::$app->session->setFlash('warning', $comanda);
            return $this->redirect('/user/view');
        }

        return $this->render('add', [
            'model' => $model
        ]);
    }

    /**
     * @param $serie
     * @return string|yii\web\Response
     * @throws yii\db\Exception
     */
    public function actionEdit($serie)
    {
        // GET-ul seriei este un string ce contine "'...'" -> stergem '' pt a putea utiliza seria
        $serie = str_replace("'", '', $serie);
        $model = Card::findOne(['serial_crd' => $serie]);
        $model->setScenario('edit');

        // Daca request-ul este trimis catre server & inputurile sunt validate
        //  facem update in baza de date & redirectionam cu mesaj de succes + query-ul rulat efectiv
        if ($model->load(yii::$app->request->post()) && $model->validate()) {
            $command = yii::$app->db->createCommand("UPDATE " . Card::tableName() . "
                SET serial_crd = :serial,
                    holder_crd = :holder,
                    expiration_crd = :expiration,
                WHERE serial_crd = :serial_crd")
                ->bindValues([
                    ':serial' => $model->serial_crd,
                    ':holder' => strtoupper($model->holder_crd),
                    ':expiration' => $model->expiration_crd,
                    ':serial_crd' => $serie,
                ]);

            $sql = $command->getRawSql();
            $command->execute();

            yii::$app->session->setFlash('success', 'Datele cardului au fost modificate cu succes!');
            yii::$app->session->setFlash('warning', $sql);
            return $this->redirect('/user/view');
        }

        return $this->render('edit', [
            'model' => $model,
        ]);

    }

    /**
     * @param $serie
     * @throws yii\db\Exception
     */
    public function actionDelete($serie)
    {
        $serie = str_replace("'", '', $serie);
        $command = Yii::$app->db->createCommand("DELETE FROM " . Card::tableName() . "
            WHERE serial_crd = :serie")
            ->bindValue(':serie', $serie);

        $sql = json_encode($command->getRawSql(), JSON_PRETTY_PRINT);
        $command->execute();

        yii::$app->session->setFlash('warning', $sql);
        return $this->redirect('/user/view');
    }
}