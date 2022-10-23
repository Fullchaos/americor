<?php
declare(strict_types = 1);

/**
 * @var yii\web\View $this
 * @var History $model
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var string $exportType
 */

use app\models\history\History;
use app\widgets\Export\Export;

$filename = 'history';
$filename .= '-' . time();

echo Export::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'ins_ts',
            'label' => Yii::t('app', 'Date'),
            'format' => 'datetime'
        ],
        [
            'label' => Yii::t('app', 'User'),
            'value' => static function(History $model) {
                return isset($model->user) ? $model->user->username : Yii::t('app', 'System');
            }
        ],
        [
            'label' => Yii::t('app', 'Type'),
            'value' => static function(History $model) {
                return $model->object;
            }
        ],
        [
            'label' => Yii::t('app', 'Event'),
            'value' => static function(History $model) {
                return $model->eventText;
            }
        ],
        [
            'label' => Yii::t('app', 'Message'),
            'value' => static function(History $model) {
                return strip_tags($model->getTemplateFactory()->getBody() ?? '');
            }
        ]
    ],
    'exportType' => $exportType,
    'batchSize' => 2000,
    'filename' => $filename
]);