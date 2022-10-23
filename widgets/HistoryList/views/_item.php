<?php
declare(strict_types = 1);

use app\models\history\HistorySearch;
use app\widgets\HistoryList\helpers\Event;

/** @var HistorySearch $model */
?>

<?= (new Event($model))->render($this) ?>
