<?php
declare(strict_types = 1);

use app\models\user\User;
use app\widgets\DateTime\DateTime;
use yii\helpers\Html;

/* @var User $user */
/* @var string $body */
/* @var string $footer */
/* @var string $footerDatetime */
/* @var string $bodyDatetime */
/* @var string $iconClass */
?>
<?= Html::tag('i', '', ['class' => "icon icon-circle icon-main white $iconClass"]) ?>

    <div class="bg-success ">
        <?= $body ?>

        <?php if (isset($bodyDatetime)): ?>
            <span>
       <?= DateTime::widget(['dateTime' => $bodyDatetime]) ?>
    </span>
        <?php endif; ?>
    </div>

<?php if (isset($user)): ?>
    <div class="bg-info"><?= $user->username ?></div>
<?php endif; ?>

<?php if (isset($content) && $content): ?>
    <div class="bg-info">
        <?= $content ?>
    </div>
<?php endif; ?>

<?php if (isset($footer) || isset($footerDatetime)): ?>
    <div class="bg-warning">
        <?= $footer ?? '' ?>
        <?php if (isset($footerDatetime)): ?>
            <span><?= DateTime::widget(['dateTime' => $footerDatetime]) ?></span>
        <?php endif; ?>
    </div>
<?php endif; ?>