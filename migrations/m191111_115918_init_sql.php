<?php
declare(strict_types = 1);

use yii\db\Migration;

/**
 * Class m191111_115918_init_sql
 */
class m191111_115918_init_sql extends Migration
{
    /**
     * @var string[]
     */
    private static $initTables = [
        'customer',
        'user',
        'history',
        'sms',
        'task',
        'call',
        'fax',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        foreach (self::$initTables as $table) {
            foreach (file(__DIR__ . '/init/' . $table . '.sql') as $sql) {
                $this->execute($sql);
            }
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = []): bool
    {
        return trim($sql) && $this->execute($sql, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        foreach (array_reverse(self::$initTables) as $table) {
            $this->delete($table);
        }
    }
}

