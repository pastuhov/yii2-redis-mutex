<?php
namespace pastuhov\yii2redismutex;

use Yii;
use yii\mutex\Mutex;
use yii\redis\Connection;
use yii\di\Instance;

/**
 * Redis mutex.
 *
 * @link http://redis.io/topics/distlock
 * @see Mutex
 */
class RedisMutex extends Mutex
{

    /**
     * @var \yii\redis\Connection
     */
    public $redis;

    /**
     * Expire time, in seconds.
     *
     * @var int
     */
    public $expireTime = 3;

    /**
     * @inheritdoc
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->redis = Instance::ensure($this->redis, Connection::className());

    }

    /**
     * Acquires lock by given name.
     *
     * @param string $name of the lock to be acquired.
     * @param integer $timeout to wait for lock to become released.
     *
     * @return boolean acquiring result.
     */
    protected function acquireLock ($name, $timeout = 0)
    {
        $redis = $this->getConnection();
        $lockValue = $this->getLockValue();
        $params = [
            $name, // Key name
            $lockValue, // Key value
            'NX', // Set if Not eXists
            'EX', // Expire time
            $this->expireTime // Seconds
        ];
        $response = $redis->executeCommand('SET', $params);

        if ($response === true) {

            return true;
        }

        return false;
    }

    /**
     * Releases lock by given name.
     *
     * @param string $name of the lock to be released.
     *
     * @return boolean release result.
     */
    protected function releaseLock ($name)
    {
        $redis = $this->getConnection();
        $lockValue = $this->getLockValue();
        $script = '
            if redis.call("get",KEYS[1]) == ARGV[1]
            then
                return redis.call("del",KEYS[1])
            else
                return 0
            end
        ';
        $params = [
            $script, // Lua script
            1, // the number of arguments that follows the script (starting from the third argument)
            $name, // Key name
            $lockValue // Key value
        ];

        return (bool)$redis->executeCommand('EVAL', $params);
    }

    /**
     * @return \yii\redis\Connection
     */
    protected function getConnection()
    {
        return $this->redis;
    }

    /**
     * @var float|false
     */
    private $_lockValue = false;

    /**
     * @return float|mixed
     */
    public function getLockValue()
    {
        if ($this->_lockValue === false) {
            $this->_lockValue = microtime(true);
        }

        return $this->_lockValue;
    }
}
