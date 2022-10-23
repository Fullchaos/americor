<?php
declare(strict_types = 1);

namespace app\models\traits;

use app\models\call\Call;
use app\models\customer\Customer;
use app\models\fax\Fax;
use app\models\sms\Sms;
use app\models\task\Task;
use app\models\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveQueryInterface;

/**
 * Общий функционал моделей.
 */
trait ObjectNameTrait
{
    public static $classes = [
        Customer::class,
        Sms::class,
        Task::class,
        Call::class,
        Fax::class,
        User::class,
    ];

    /**
     * @param string $name
     * @param bool $throwException
     * @return ActiveQuery|ActiveQueryInterface|null
     */
    public function getRelation($name, $throwException = true)
    {
        $getter = 'get' . $name;
        $class = self::getClassNameByRelation($name);

        if (!method_exists($this, $getter) && $class) {
            return $this->hasOne($class, ['id' => 'object_id']);
        }

        return parent::getRelation($name, $throwException);
    }

    /**
     * @param string $className
     * @return mixed
     */
    public static function getObjectByTableClassName(string $className): string
    {
        if (method_exists($className, 'tableName')) {
            return str_replace(['{', '}', '%'], '', $className::tableName());
        }

        return $className;
    }

    /**
     * @param $relation
     * @return string|null
     */
    public static function getClassNameByRelation($relation): ?string
    {
        foreach (self::$classes as $class) {
            if (self::getObjectByTableClassName($class) === $relation) {
                return $class;
            }
        }
        return null;
    }
}