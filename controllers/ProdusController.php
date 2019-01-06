<?php
/**
 * Created by PhpStorm.
 * User: timurmengazi
 * Date: 04.12.2018
 * Time: 16:40
 */

namespace app\controllers;


use app\models\Produs;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii;

class ProdusController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => \app\components\AccessRule::className(),
                ],
                'only' => ['admin', 'view', 'edit', 'delete', 'add', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['admin', 'view', 'edit', 'delete', 'add', 'index'],
                        'roles' => [User::TYPE_ADMINISTRATOR]
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'index'],
                        'roles' => ['?']
                    ]
                ],
            ],
        ];
    }


    /**
     * @param string $filter
     * @return string
     * @throws yii\db\Exception
     * @throws yii\web\ForbiddenHttpException
     */
    public function actionIndex($filter = '')
    {
        $query = "SELECT p.id_prd, p.nume_prd, p.pret_prd, p.imagine_prd, t.denumire_ptp, a.denumire_anm
             FROM " . Produs::tableName() . " as p
             INNER JOIN animals_anm as a ON p.idanm_prd = a.id_anm
             INNER JOIN produs_type as t ON p.tip_prd = t.id_ptp";

        if ($filter != '' && $filter == 'ASC' || $filter == 'DESC') {
            $query .= " ORDER BY p.pret_prd " . $filter;
        }

        $sql = yii::$app->db->createCommand($query)->getRawSql();

        $products = yii::$app->db->createCommand($query)
            ->queryAll(\PDO::FETCH_ASSOC);

//        echo "<PRE>";
//        print_r($products);
//        die();

        return $this->render('index', [
            'products' => $products
        ]);
    }

    public function actionView($id)
    {
        $model = Produs::findOne($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * @throws yii\db\Exception
     */
    public function actionAdd()
    {
        $model = new Produs(['scenario' => 'add']);

        // Initializare comanda sql
        $command = yii::$app->db->createCommand("INSERT INTO " . Produs::tableName() . " 
                    (`nume_prd`, `descriere_prd`, `idanm_prd`, `tip_prd`, `pret_prd`, `stoc_prd`, `imagine_prd`)
                     VALUES (:nume, :descriere, :idanm_prd, :tip, :pret, :stoc, :imagine)");

        // Array-uri selectie tip animal & tip de hrana
        $typeFood = array_column(yii::$app->db->createCommand("SELECT * FROM `produs_type`")->queryAll(),
            'denumire_ptp',
            'id_ptp');
        $typeAnimal = array_column(yii::$app->db->createCommand("SELECT * FROM `animals_anm`")->queryAll(),
            'denumire_anm',
            'id_anm');

        if ($model->load(yii::$app->request->post())) {
            // Daca inputurile sunt validate & exista poza, redimensionam si salvam pe "server" a.k.a disk
            $model->pret_prd = (float)$model->pret_prd;
            if ($model->imagine_prd = UploadedFile::getInstance($model, 'imagine_prd')) {
                if ($model->validate()) {
                    $file = Produs::saveFile(Yii::$app->basePath, $model->imagine_prd->extension);
                    $model->imagine_prd->saveAs(Produs::UPLOAD_FOLDER . $file);
                    $model->imagine_prd = $file;
                    Produs::resizeImage(Produs::UPLOAD_FOLDER . $file);
                }
            } else {
                // Daca nu exista poza, setam default fara!
                $model->imagine_prd = 'nologo.png';
                if (!$model->validate(['nume_prd', 'descriere_prd', 'idanm_prd', 'tip_prd', 'pret_prd', 'stoc_prd'])) {
                    echo "<pre>";
                    print_r($model->getErrors());
                    die();
                }
            }

            // Setam parametrii din query in functie de inputurile utilizatorului
            $command->bindValues([
                ":nume" => $model->nume_prd,
                ":descriere" => $model->descriere_prd,
                ":idanm_prd" => $model->idanm_prd,
                ":tip" => $model->tip_prd,
                ":pret" => (float)$model->pret_prd,
                ":stoc" => (int)$model->stoc_prd,
                ":imagine" => $model->imagine_prd
            ]);
            // Executie query, setare flash & redirect catre pagina principala
            $sql = json_encode($command->getRawSql(), JSON_PRETTY_PRINT);
            $command->execute();
            yii::$app->session->setFlash('success', 'Produs adăugat cu succes!');
            yii::$app->session->setFlash('warning', $sql);
            return $this->redirect('/site/index');
        }

        return $this->render('add', [
            'model' => $model,
            'typeFood' => $typeFood,
            'typeAnimal' => $typeAnimal
        ]);
    }

    /**
     * @param $nume
     * @throws yii\db\Exception
     */
    public function actionDelete($nume)
    {
        $command = yii::$app->db->createCommand("DELETE FROM " . Produs::tableName() . "
            WHERE denumire_prd = :nume")
            ->bindValue(':nume', $nume);
        $sql = $command->getRawSql();

        $command->execute();
        yii::$app->session->setFlash('danger', 'Produs șters cu succes!');
        yii::$app->session->setFlash('warning', $sql);
        return $this->redirect('site/index');
    }

}