<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CustomChangeUsernameForm extends Model
{
    public $newUsername;

    public function rules()
    {
        return [
            [['newUsername'], 'required'],
        ];
    }
}