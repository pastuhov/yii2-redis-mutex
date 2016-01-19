<?php
namespace pastuhov\yii2redismutex\tests;

use Yii;
use pastuhov\yii2redismutex;

/**
 *
 */
class RedisMutexTest extends \PHPUnit_Framework_TestCase
{

    public function testRedisConnection()
    {
        $redis = $this->getRedis();

        $redis->set('test', 'test value');
        $value = $redis->get('test');

        $this->assertSame('test value', $value);
    }

    public function testBasic()
    {
        $redis = $this->getRedis();
        /** @var \pastuhov\yii2redismutex\RedisMutex $mutex */
        $mutex = \Yii::createObject([
            'class' => \pastuhov\yii2redismutex\RedisMutex::className(),
            'redis' => $redis
        ]);
        $value = 0;
        $mutexName = 'testlock';

        foreach ([1,2,3] as $k)
        {
            if ($mutex->acquire($mutexName)) {
                $value++;
            }
            if ($k === 2) {
                $mutex->release($mutexName);
            }
        }

        $this->assertSame(2, $value);

    }

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        \Yii::$app->setComponents(
            [
                'redis' => [
                    'class' => 'yii\redis\Connection',
                    'hostname' => 'localhost',
                    'port' => 6379,
                    'database' => 0,
                ],
            ]
        );
    }

    /**
     * @return \yii\redis\Connection
     */
    public static function getRedis()
    {
        /** @var \yii\redis\Connection $redis */
        $redis = \Yii::$app->redis;

        return $redis;
    }
}
