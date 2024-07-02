<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CustomChangePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'confirmPassword'], 'required'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
}