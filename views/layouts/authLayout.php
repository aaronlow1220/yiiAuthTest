<?php
/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use app\assets\AuthAsset;

AuthAsset::register($this);
$loggedInUser = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?= Html::csrfMetaTags() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="all-content">
        <nav class="navbar-container">
            <div class="navbar-item">
                <a class="custom-btn" href="/">首頁</a>
            </div>
            <?php if (!$loggedInUser) { ?>
                <div class="navbar-item">
                    <a class="custom-btn" href="/login">登入</a>
                </div>
                <div class="navbar-item">
                    <a class="custom-btn" href="/register">註冊</a>
                </div>
            <?php } else { ?>
                <div class="navbar-item">
                    <a class="custom-btn" href="/profile">個人檔案</a>
                </div>
                <div class="navbar-item">
                    <a class="custom-btn" href="/logout">登出</a>
                </div>
            <?php } ?>
        </nav>
    </div>
    <div class="main-content">
        <?= $content ?>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>