<?php


use Dotenv\Dotenv;

trait TestIOSPassKitSetupTrait
{
    protected function loadEnv()
    {
        return (new Dotenv(__DIR__, "../../.env"))->load();
    }

    protected function callObjectMethod($object, $method, $attributes = [])
    {
        $method = $this->getMethod($method, get_class($object));
        return $method->invokeArgs($object, $attributes);
    }

    protected function getMethod($methodName, $className)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
}
