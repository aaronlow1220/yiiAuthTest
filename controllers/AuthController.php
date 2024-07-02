<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;
use app\models\CustomRegisterForm;
use app\models\CustomLoginForm;
use app\models\CustomChangePasswordForm;
use app\models\CustomChangeUsernameForm;
use app\models\users;

class AuthController extends Controller
{
    public $layout = 'authLayout';

    public function actionIndex()
    {
        $loggedInUser = Yii::$app->user->identity;
        return $this->render('index', ["loggedInUser" => $loggedInUser]);
    }

    public function actionRegister()
    {
        $model = new CustomRegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $registerSuccess = false;
            $query = users::find();

            $user = $query->where(['email' => $model->email])->one();
            if ($user == null) {
                $userModel = new users();
                $userModel->uuid = $this->gen_uuid();
                $userModel->username = $model->username;
                $userModel->email = $model->email;
                $userModel->password = password_hash($model->password, PASSWORD_DEFAULT);
                // $userModel->created_at = time();
                // $userModel->updated_at = time();
                $userModel->status = users::STATUS_ACTIVE;
                if ($userModel->save()) {
                    $registerSuccess = true;
                    return $this->redirect(["/register-success", "success" => $registerSuccess]);
                }
            }
            return $this->render('register', [
                'model' => $model,
            ]);
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegisterSuccess($success = 0)
    {
        if ($success == 0) {
            return $this->goHome();
        }
        return $this->render("registerSuccess");
    }

    public function actionLogin()
    {
        $model = new CustomLoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $loggedUser = users::find()->where(["email"=> $model->email])->one();
            if($loggedUser == null){
                return $this->redirect("/register");
            }
            if(password_verify($model->password, $loggedUser->password)){
                Yii::$app->user->login($loggedUser);
                return $this->goHome();
            }
            return $this->render("login", ["model" => $model]);
        }

        return $this->render('login', ["model" => $model]);
    }

    public function actionProfile(){
        $loggedInUser = Yii::$app->user->identity;
        if(!$loggedInUser){
            return $this->goHome();
        }
        return $this->render("profile", ["loggedInUser" => $loggedInUser]);
    }

    public function actionChangePassword(){
        $loggedInUser = Yii::$app->user->identity;
        $model = new CustomChangePasswordForm();
        if(!$loggedInUser){
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = users::find()->where(["email"=> $loggedInUser->email])->one();
            if(password_verify($model->oldPassword, $user->password)){
                $user->password = password_hash($model->newPassword, PASSWORD_DEFAULT);
                if($user->save()){
                    return $this->redirect("/profile");
                }
            }
        }
        return $this->render("changePassword", ["loggedInUser" => $loggedInUser, "model"=> $model]);
    }
    
    public function actionChangeUsername(){
        $loggedInUser = Yii::$app->user->identity;
        $model = new CustomChangeUsernameForm();
        if(!$loggedInUser){
            return $this->goHome();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = users::find()->where(["email"=> $loggedInUser->email])->one();
            $user->username = $model->newUsername;
            if($user->save()){
                return $this->redirect("/profile");
            }
        }
        return $this->render("changeUsername", ["loggedInUser" => $loggedInUser, "model"=> $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    function gen_uuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}