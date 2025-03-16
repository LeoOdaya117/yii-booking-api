<?php
namespace app\controllers\api;

use Yii;
use yii\db\ActiveRecord;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\Rooms;
use yii\behaviors\TimestampBehavior;
use yii\filters\auth\HttpBearerAuth;

class RoomsController extends Controller
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

    public function actionIndex(){
        $query = Rooms::find();

        // Add filtering
        $params = Yii::$app->request->queryParams;
        $query->andFilterWhere(['like', 'room_number', $params['name'] ?? null])
              ->andFilterWhere(['room_type' => $params['type'] ?? null])
              ->andFilterWhere(['status' => $params['status'] ?? null]);

        // Add pagination
        $pagination = new \yii\data\Pagination(['totalCount' => $query->count()]);
        $query->offset($pagination->offset)->limit($pagination->limit);

        return [
            'success' => true,
            'data' => $query->all(),
            'pagination' => [
            'total' => $pagination->totalCount,
            'pageCount' => $pagination->getPageCount(),
            'currentPage' => $pagination->getPage() + 1,
            'perPage' => $pagination->getPageSize(),
            ],
        ];
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function actionCreate()
    {
        $model = new Rooms();
        $model->load(Yii::$app->request->post(), '');

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
            return ['success' => true, 'message' => 'Room deleted successfully'];
        }

        return ['success' => false, 'message' => 'Failed to delete Room'];
    }

    protected function findModel($id)
    {
        if (($model = Rooms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested Room does not exist.');
    }
}
