<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CustomLoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
        ];
    }
}