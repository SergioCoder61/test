<?php
namespace backend\controllers;

use Yii;
use app\Models\Apple;
use app\Models\Color;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'create', 'eat', 'fall'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Apple();
        $refresh = $model->refreshStaus();
        if ($refresh) {
       	    $fallenApples = $model->getFallenApples();
       	    $hangingApples = $model->getHangingApples();
       	    $eatenApples = $model->getEatenApples();
		}
        return $this->render('index', [
            'fallenApples' => $fallenApples,
            'hangingApples' => $hangingApples,
            'eatenApples' => $eatenApples,
        ]);
    }

    /**
     * Создание новых яблок.
     * 
     */
    public function actionCreate()
    {
        $amount = $_POST['amount'];
        $emergence_time = time();
        for ($i=0; $i<$amount; $i++) {
            $command = Yii::$app->db->createCommand(
            'SELECT * FROM color ORDER BY RAND() LIMIT 1');
            $colors = $command->queryAll();
            foreach ($colors as $color) {
                $color_id = $color['id'];
            }
            $command = Yii::$app->db->createCommand()
            ->insert('apple', [
                'id' => NULL,
                'color_id' => $color_id,
                'emergence_time' => $emergence_time,
                'fall_time' => '',
                'status_id' => 1,
                'eating_percent' => 0,
                ])->execute();
        }
        return $this->redirect(['index']);
    }

    /**
     * Падение яблок с дерева.
     * 
     */
    public function actionFall()
    {
        $id = $_POST['id'];
        $fall_time = time();
        $command = Yii::$app->db->createCommand(
        'UPDATE apple SET status_id=2, fall_time=' . $fall_time .
        ' WHERE id=' . $id);
        $command->execute();
        return $this->redirect(['index']);
    }

    /**
     * Поедание яблок.
     * 
     */
    public function actionEat()
    {
        $id = $_POST['id'];
        $eat = $_POST['eat'];
        $eat_time = time();
        if ($eat < 100) {
            $command = Yii::$app->db->createCommand(
            'UPDATE apple SET eating_percent=' . $eat .
            ' WHERE id=' . $id);
            $command->execute();
        } else {
            $command = Yii::$app->db->createCommand(
            'UPDATE apple SET eating_percent=100, status_id=3, eat_time =' . $eat_time .
            ' WHERE id=' . $id);
            $command->execute();			
        }
        return $this->redirect(['index']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
