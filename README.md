# Yii2 redis mutex

[![Build Status](https://travis-ci.org/pastuhov/yii2-redis-mutex.svg)](https://travis-ci.org/pastuhov/yii2-redis-mutex)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pastuhov/yii2-redis-mutex/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-redis-mutex/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pastuhov/yii2-redis-mutex/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-redis-mutex/?branch=master)
[![Total Downloads](https://poser.pugx.org/pastuhov/yii2-redis-mutex/downloads)](https://packagist.org/packages/pastuhov/yii2-redis-mutex)

Under development

## Install

Via Composer

``` bash
$ composer require pastuhov/yii2-redis-mutex
```

## Features

* Deadlock free
* Robust

## Disadvantages
* no spinlock
* non distributed

## Usage

Configure the [[yii\base\Application::controllerMap|controller map]] in the application configuration. For example:
```php
$mutex = \Yii::createObject([
	'class' => \pastuhov\yii2redismutex\RedisMutex::className(),
	'redis' => $redisConnection
]);

$mutexName = 'lock';

if ($mutex->acquire($mutexName)) {
	$value++;
	$mutex->release($mutexName);
}
```

## Testing

```bash
$ composer test
```
or
```bash
$ phpunit
```

## Debugging

For debugging purposes use:

```bash
$ redis-cli monitor
```
or 

```bash
$ tail -f tests/runtime/logs/app.log -n 1000
```

## Security

If you discover any security related issues, please email kirill@pastukhov.su instead of using the issue tracker.

## Credits

- [Kirill Pastukhov](https://github.com/pastuhov)
- [All Contributors](../../contributors)

## License

GNU General Public License, version 2. Please see [License File](LICENSE) for more information.
