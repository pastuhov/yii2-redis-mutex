<?php
namespace pastuhov\yii2redismutex\tests;

use Yii;
use pastuhov\yii2redismutex;

/**
 *
 */
class RedisMutexTest extends \PHPUnit_Framework_TestCase
{

    public function testBasic()
    {
        \Yii::$app->setComponents(
            [
                'redis' => [
                    'class' => 'yii\redis\Connection',
                    'hostname' => 'localhost',
                    'port' => 6379,
                    'database' => 0,
                ]
            ]
        );

        /** @var \yii\redis\Connection $redis */
        $redis = \Yii::$app->redis;

        $redis->set('test', 'test value');

        $value = $redis->get('test');

        $this->assertSame('test value', $value);
    }
}
