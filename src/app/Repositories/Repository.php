<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace App\Repositories;

abstract class Repository
{
    protected static $model;

    /**
     * @param $method
     * @param $attr
     * @return false|mixed
     */
    public function __call($method, $attr)
    {
        return call_user_func_array([static::$model, $method], $attr);
    }

    /**
     * @param $method
     * @param $attr
     * @return false|mixed
     */
    public static function __callStatic($method, $attr)
    {
        self::getModel();

        return call_user_func_array([static::$model, $method], $attr);
    }

    /**
     * @param $model
     * @return void
     */
    protected function setModel($model)
    {
        static::$model = $model;
    }

    protected static function getModel()
    {
        if (!static::$model) {
            $service = get_called_class();
            $model = (new $service())->getModel();
            static::$model = $model;
        }

        return static::$model;
    }
}
