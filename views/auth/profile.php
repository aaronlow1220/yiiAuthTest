<?php
/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '登入';
?>
<div class="center-content">
    <div class="auth-card">
        <h1 class="auth-text"><?php echo $loggedInUser->username; ?></h1>
        <a class="custom-btn" href="/changePassword">更換密碼</a>
        <a class="custom-btn" href="/changeUsername">更換使用者名稱</a>
        <a class="custom-btn" href="/logout">登出</a>
    </div>

</div>