<?php
namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\Bookings;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;

class BookingsController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        
        if (!$user) {
            throw new ForbiddenHttpException('You are not authorized to access this resource.');
        }

        return Bookings::find()->where(['user_id' => $user->id])->all();

    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function actionCreate()
    {
        
        $model = new Bookings();

        // Get raw JSON input
        $rawBody = Yii::$app->request->getRawBody();
        $request = json_decode($rawBody, true); // Convert JSON string to an associative array


        $model->load($request, '');

        if ($model->save()) {
            return ['success' => true, 'data' => $model];
        }

        return ['success' => false, 'errors' => $model->errors];
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            return ['success' => true, 'data' => $model];
        }

        return ['success' => false, 'errors' => $model->errors];
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            return ['success' => true, 'message' => 'Booking deleted successfully'];
        }

        return ['success' => false, 'message' => 'Failed to delete booking'];
    }

    protected function findModel($id)
    {
        if (($model = Bookings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested booking does not exist.');
    }
}
