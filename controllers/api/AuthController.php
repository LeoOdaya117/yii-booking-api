<?php 

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use app\models\User;
use yii\web\Response;
use yii\web\BadRequestHttpException;

class AuthController extends Controller
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
        ];
    }

    // ✅ Signup API
    public function actionSignup()
    {
        $rawBody = Yii::$app->request->getRawBody();
        $request = json_decode($rawBody, true);

        if (!is_array($request) || !isset($request['name'], $request['email'], $request['password'])) {
            throw new BadRequestHttpException('Invalid or missing required fields.');
        }

        // Check if user already exists
        if (User::findOne(['email' => $request['email']])) {
            throw new BadRequestHttpException('Email already registered.');
        }

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->setPassword($request['password']);
        $user->generateAuthKey();
        $user->generateAccessToken();

        if ($user->save()) {
            return ['success' => true, 'message' => 'User registered successfully', 'access_token' => $user->access_token];
        }

        return ['success' => false, 'errors' => $user->errors];
    }




    public function actionLogin()
    {
        // Get raw JSON input
        $rawBody = Yii::$app->request->getRawBody();
        $request = json_decode($rawBody, true); // Convert JSON string to an associative array

        // Check if decoding was successful
        if (!is_array($request) || !isset($request['email'], $request['password'])) {
            throw new BadRequestHttpException('Invalid or missing email/password.');
        }

        // Find user by email
        $user = User::findOne(['email' => $request['email']]);
        // Generate a new access token on each login
        $user->access_token = Yii::$app->security->generateRandomString(); // New token
        $user->save(false);
        
        if (!$user || !$user->validatePassword($request['password'])) {
            throw new BadRequestHttpException('Invalid username or password.');
        }

        return ['success' => true, 'message' => 'Login successful', 'access-token' => $user->access_token];
    }

    public function actionLogout()
    {
        $authHeader = Yii::$app->request->headers->get('Authorization');

        if (!$authHeader || !preg_match('/^Bearer\s+(.+)$/', $authHeader, $matches)) {
            throw new BadRequestHttpException('Missing or invalid Authorization header.');
        }

        $token = $matches[1]; // Extract token

        $user = User::findOne(['access_token' => $token]);

        if (!$user) {
            throw new BadRequestHttpException('Invalid token.');
        }

        // Invalidate token by clearing it
        $user->access_token = null;
        $user->save();

        return ['success' => true, 'message' => 'Logout successful'];
    }


}
