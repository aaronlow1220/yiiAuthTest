<?php
/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '更換密碼';
?>
<div class="center-content">
    <div class="auth-card">
        <h1 class="auth-text">更換密碼</h1>
        <?php $form = ActiveForm::begin(["id" => "register-form"]) ?>
        <?= $form->field($model, "oldPassword")->passwordInput() ?>
        <?= $form->field($model, "newPassword")->passwordInput() ?>
        <?= $form->field($model, "confirmPassword")->passwordInput() ?>
        <div class="form-group">
            <?= Html::submitButton("提交", ["class" => "custom-btn"]) ?>
        </div>
        <?php $form = ActiveForm::end() ?>
    </div>

</div>