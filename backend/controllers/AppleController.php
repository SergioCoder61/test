<?php

namespace backend\controllers;

use Yii;
use backend\models\Apple;
use backend\models\AppleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'blank';
 
        $model = new Apple;
        $res = $model->refreshStaus();
        $colors = $model->appleColors();
 
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'colors' => $colors,            
        ]);
    }

    /**
     * Creates a new Apple model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apple();
        $amount = random_int(1, 5);
        $colors = $model->appleColors();
        $colorKey = array_rand($colors, 1);

        $saveErrors = 0;
        for ($i=0; $i<$amount; $i++) {
            $model = new Apple();
            $model->color_css = $colors[$colorKey]['cssName'];
            $model->color_rus = $colors[$colorKey]['rusName'];
            $model->emergence_time = time();

            $result = ($model->save());
            if ($result == false) $saveErrors++;  
        }
        if ($saveErrors == 0) {
            $message = 'Новые яблоки успешно созданы. Цвет: ' . $colors[$colorKey]['rusName'] . ', кол-во: ' . $amount . ' шт.';
            Yii::$app->session->setFlash('success', $message);
        } else {
            $message = 'Ошибка при сохранении данных';
            Yii::$app->session->setFlash('error', $message);            
        }

            return $this->redirect(['index']);
    }

    /**
     * Падение яблока.
     * @param integer $id
     * @return mixed
     */
    public function actionFall($id)
    {
        $result = Yii::$app->db->createCommand('UPDATE apple SET fall_time=:time, status_id=1 WHERE id=:id')
            ->bindValue(':time', time())
            ->bindValue(':id', $id)
            ->execute();

        if ($result) {
            $message = 'Яблоко ID ' . $id . ' успешно упало';
            Yii::$app->session->setFlash('success', $message);
        } else {
            $message = 'Ошибка при сохранении данных';
            Yii::$app->session->setFlash('error', $message);            
        }

        return $this->redirect(['index']);
    }

    /**
     * Поедание яблока
     * @param integer $id
     * @return mixed
     */
    public function actionEat($id)
    {
        $model = $this->findModel($id);
        $newEatingPercent = $model->eating_percent + 25;
        if ($newEatingPercent === 100) {
            $newStatusID = 2;
        } else {
            $newStatusID = 1;            
        }

        $result = Yii::$app->db->createCommand('UPDATE apple SET eating_percent=:eating_percent, status_id=:status_id WHERE id=:id')
            ->bindValue(':eating_percent', $newEatingPercent)
            ->bindValue(':status_id', $newStatusID)
            ->bindValue(':id', $id)
            ->execute();

        if ($result) {
            $message = 'Яблоко ID ' . $id . ' успешно съедено на ' . $newEatingPercent . '%';
            Yii::$app->session->setFlash('success', $message);
        } else {
            $message = 'Ошибка при сохранении данных';
            Yii::$app->session->setFlash('error', $message);            
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
