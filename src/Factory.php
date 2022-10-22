<?php

namespace BugrovWeb\YandexSchedule;

class Factory
{
    public static function createRequest(string $className)
    {
        $className = __NAMESPACE__.'\\'.$className;

        try {
            return new $className;
        } catch (\Exception $exception) {
            throw new \Exception("Класс $className не найден");
        }
    }
}