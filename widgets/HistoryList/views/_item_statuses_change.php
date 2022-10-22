<?php
declare(strict_types = 1);

use app\models\History;
use app\widgets\DateTime\DateTime;

/* @var History $model */
/* @var string $oldValue */
/* @var string $newValue */
/* @var string $content */
?>

    <div class="bg-success ">
        <?= "$model->eventText " .
        "<span class='badge badge-pill badge-warning'>" . ($oldValue ?? "<i>not set</i>") . "</span>" .
        " &#8594; " .
        "<span class='badge badge-pill badge-success'>" . ($newValue ?? "<i>not set</i>") . "</span>"
        ?>

        <span><?= DateTime::widget(['dateTime' => $model->ins_ts]) ?></span>
    </div>

<?php if (isset($model->user)): ?>
    <div class="bg-info"><?= $model->user->username; ?></div>
<?php endif; ?>

<?php if (isset($content) && $content): ?>
    <div class="bg-info">
        <?= $content ?>
    </div>
<?php endif; ?>