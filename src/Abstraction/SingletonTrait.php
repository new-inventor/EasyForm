<?php

namespace NewInventor\EasyForm\Abstraction;

trait SingletonTrait
{
    protected static $instance;

    /**
     * SingletonTrait constructor.
     */
    protected function __construct()
    {
    }

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Клонирование запрещено
     */
    protected function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    protected function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    protected function __wakeup()
    {
    }
}