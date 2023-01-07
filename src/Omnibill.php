<?php
namespace Omnibill;

use Omnibill\Common\GatewayFactory;

class Omnibill
{
    private static GatewayFactory $factory;

    public static function getFactory(): GatewayFactory
    {
        if (is_null(self::$factory)) {
            self::$factory = new GatewayFactory;
        }

        return self::$factory;
    }

    public static function setFactory(GatewayFactory $factory = null): void
    {
        self::$factory = $factory;
    }

    public static function __callStatic($method, $parameters)
    {
        $factory = self::getFactory();

        return call_user_func_array(array($factory, $method), $parameters);
    }
}
