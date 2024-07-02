<?php

/** @var yii\web\View $this */

$this->title = '使用者驗證系統';
?>
<div class="center-content">
    <div class="main-text">
        <h1>使用者驗證系統</h1>
        <?php if (!$loggedInUser) { ?>
            <p>未登入</p>
        <?php } else { ?>
            <p>你好，<?php echo $loggedInUser->username; ?></p>
        <?php } ?>
        
    </div>
</div>