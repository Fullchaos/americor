<?php
declare(strict_types = 1);

namespace app\models\history;

use app\models\call\Call;
use app\models\customer\Customer;
use app\models\fax\Fax;
use app\models\sms\Sms;
use app\models\task\Task;
use app\widgets\HistoryList\helpers\templates\DefaultTemplateFactory;
use app\widgets\HistoryList\helpers\templates\TemplateFactory;
use ReflectionClass;
use ReflectionException;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Бизнес логика модели историй.
 */
class History extends HistoryActiveRecord
{
    /**
     * Нужен отдельный сервисный класс для этих типов событий.
     */
    public const TYPE_CALL = 'call';
    public const TYPE_SMS = 'sms';
    public const TYPE_CUSTOMER = 'customer';
    public const TYPE_TASK = 'task';
    public const TYPE_CALL_YTEL = 'call_ytel';
    public const TYPE_DEAL = 'deal';
    public const TYPE_LEAD = 'lead';
    public const TYPE_FAX = 'fax';

    public const EVENT_OBJECTS = [
        self::TYPE_CALL => Call::class,
        self::TYPE_CALL_YTEL => Call::class,
        self::TYPE_SMS => Sms::class,
        self::TYPE_CUSTOMER => Customer::class,
        self::TYPE_DEAL => Customer::class,
        self::TYPE_LEAD => Customer::class,
        self::TYPE_TASK => Task::class,
        self::TYPE_FAX => Fax::class
    ];

    /**
     * Это тоже нужно вынести в соответствующие классы.
     * @return array
     */
    public static function getEventTexts(): array
    {
        return [
            Task::EVENT_CREATED_TASK => Yii::t('app', 'Task created'),
            Task::EVENT_UPDATED_TASK => Yii::t('app', 'Task updated'),
            Task::EVENT_COMPLETED_TASK => Yii::t('app', 'Task completed'),

            Sms::EVENT_INCOMING_SMS => Yii::t('app', 'Incoming message'),
            Sms::EVENT_OUTGOING_SMS => Yii::t('app', 'Outgoing message'),

            Customer::EVENT_CUSTOMER_CHANGE_TYPE => Yii::t('app', 'Type changed'),
            Customer::EVENT_CUSTOMER_CHANGE_QUALITY => Yii::t('app', 'Property changed'),

            Call::EVENT_OUTGOING_CALL => Yii::t('app', 'Outgoing call'),
            Call::EVENT_INCOMING_CALL => Yii::t('app', 'Incoming call'),

            Fax::EVENT_INCOMING_FAX => Yii::t('app', 'Incoming fax'),
            Fax::EVENT_OUTGOING_FAX => Yii::t('app', 'Outgoing fax'),
        ];
    }

    /**
     * @param $event
     * @return mixed
     */
    public static function getEventTextByEvent($event)
    {
        return static::getEventTexts()[$event] ?? $event;
    }

    /**
     * @return mixed|string
     */
    public function getEventText()
    {
        return static::getEventTextByEvent($this->event);
    }

    /**
     * @param string $attribute Атрибут который пытаемся вытащить.
     * @param string $type Тип значения old|new.
     * @return string|null
     */
    public function getDetailValue(string $attribute, string $type): ?string
    {
        $detail = json_decode($this->detail);
        return ArrayHelper::getValue($detail->changedAttributes->{$attribute} ?? [], $type);
    }

    /**
     * Создает объект нужной фабрики можно вынести в отдельный сервис вместе с getHistoryObject.
     * @return TemplateFactory
     * @throws InvalidConfigException
     */
    public function getTemplateFactory(): TemplateFactory
    {
        $events = $this->getHistoryObject($this->object);
        $factory = ArrayHelper::getValue($events, $this->event);
        return Yii::createObject(
            null !== $factory && true === class_exists($factory) ? $factory : DefaultTemplateFactory::class, [$this]
        );
    }

    /**
     * @param string $objectType
     * @return false|mixed
     */
    public function getHistoryObject(string $objectType)
    {
        try {
            $reflectionClass = new ReflectionClass(ArrayHelper::getValue(self::EVENT_OBJECTS, $objectType));
        } catch (ReflectionException $exception) {
            $reflectionClass = null;
            // Уведомляем что отсутствует тип события.
            Yii::warning($exception->getMessage() . ' Обработчик для объекта: ' . $objectType);
        }
        $events = $reflectionClass->getConstant('EVENTS');
        return false !== $events ? $events : [];
    }
}