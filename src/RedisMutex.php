<?php
namespace pastuhov\yii2redismutex;

use Yii;
use yii\mutex\DbMutex;

/**
 * D
 *
 * @see Mutex
 */
class RedisMutex extends DbMutex
{

    public $db = 'db';


    public function init()
    {
        parent::init();

    }

    /**
     * This method should be extended by concrete mutex implementations. Acquires lock by given name.
     *
     * @param string $name of the lock to be acquired.
     * @param integer $timeout to wait for lock to become released.
     *
     * @return boolean acquiring result.
     */
    protected function acquireLock ($name, $timeout = 0)
    {
        // TODO: Implement acquireLock() method.
    }

    /**
     * This method should be extended by concrete mutex implementations. Releases lock by given name.
     *
     * @param string $name of the lock to be released.
     *
     * @return boolean release result.
     */
    protected function releaseLock ($name)
    {
        // TODO: Implement releaseLock() method.
    }
}
