<?php

namespace BugrovWeb\YandexSchedule;

/**
 * @method static getScheduleBetweenStations(string $from, string $to, string $system = Transport::SYSTEM_TYPE_YANDEX, string $showSystems = Transport::SYSTEM_TYPE_YANDEX, string $date = null, string $transportTypes = null, int $offset = 0, int $limit = 100, bool $addDaysMask = false, bool $transfers = false)
 * @method static getScheduleOfFlightsByStation(string $station, string $system = Transport::SYSTEM_TYPE_YANDEX, string $showSystems = Transport::SYSTEM_TYPE_YANDEX, string $date = null, string $transportTypes = null, string $direction = null, string $event = Transport::EVENT_TYPE_DEPARTURE)
 * @method static getListOfStations(string $uid, string $showSystems = null, string $date = null, string $from = null, string $to = null)
 * @method static getListOfNearestStations(string $lat, string $lng, int $distance, int $offset = 0, int $limit = 100, string $stationTypes = null, string $transportTypes = null)
 * @method static getNearestCity(string $lat, string $lng, int $distance = 10)
 * @method static getCarrierInfo(string $code, string $system = Transport::SYSTEM_TYPE_YANDEX)
 * @method static getAllAvailableStations()
 * @method static getCopyright()
 */

class Transport
{
    /**
     * Типы запросов к API
     */
    const API_TYPE_SEARCH = 'search';
    const API_TYPE_SCHEDULE = 'schedule';
    const API_TYPE_THREAD = 'thread';
    const API_TYPE_NEAREST_STATIONS = 'nearest_stations';
    const API_TYPE_NEAREST_SETTLEMENT = 'nearest_settlement';
    const API_TYPE_CARRIER = 'carrier';
    const API_TYPE_STATIONS_LIST = 'stations_list';
    const API_TYPE_COPYRIGHT = 'copyright';

    /**
     * Типы транспорта
     */
    const TRANSPORT_TYPE_PLANE = 'plane';
    const TRANSPORT_TYPE_TRAIN = 'train';
    const TRANSPORT_TYPE_SUBURBAN = 'suburban';
    const TRANSPORT_TYPE_BUS = 'bus';
    const TRANSPORT_TYPE_WATER = 'water';
    const TRANSPORT_TYPE_SEA = 'sea';
    const TRANSPORT_TYPE_RIVER = 'river';
    const TRANSPORT_TYPE_HELICOPTER = 'helicopter';

    /**
     * Системы кодирования
     */
    const SYSTEM_TYPE_YANDEX = 'yandex';
    const SYSTEM_TYPE_IATA = 'iata';
    const SYSTEM_TYPE_SIRENA = 'sirena';
    const SYSTEM_TYPE_EXPRESS = 'express';
    const SYSTEM_TYPE_ESR = 'esr';
    const SYSTEM_TYPE_ALL = 'all';

    /**
     * События, для которых нужно отфильтровать нитки в расписании
     */
    const EVENT_TYPE_DEPARTURE = 'departure';
    const EVENT_TYPE_ARRIVAL = 'arrival';

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if (substr($name, 0, 3) !== 'get') {
            throw new \Exception('Метод не существует!');
        }

        $className = substr($name, 3);

        try {
            return Factory::createRequest($className)->getData(...$arguments);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Устанавливает ключ API
     *
     * @param string $apiKey ключ API
     * @return void
     */
    public static function setApiKey(string $apiKey): void
    {
        Client::getInstance()->setApiKey($apiKey);
    }

    /**
     * Возвращает установленный API-ключ
     *
     * @return string
     * @throws \Exception
     */
    public static function getApiKey(): string
    {
        if (!is_string(Client::getInstance()->getApiKey())) {
            throw new \Exception('API ключ не задан');
        }

        return Client::getInstance()->getApiKey();
    }

    /**
     * Устанавливает формат возвращаемых данных
     *
     * @param string $format формат данных
     * @return void
     * @throws \Exception
     */
    public static function setFormat(string $format): void
    {
        Client::getInstance()->setFormat($format);
    }

    /**
     * Возвращает установленный формат ответа
     *
     * @return string
     */
    public static function getFormat(): string
    {
        return Client::getInstance()->getFormat();
    }

    /**
     * Устанавливает язык возвращаемой информации
     *
     * @param string $lang код языка
     * @return void
     * @throws \Exception
     */
    public static function setLang(string $lang): void
    {
        Client::getInstance()->setLang($lang);
    }

    /**
     * Получает язык возвращаемой информации, в формате <код языка>_<код страны>
     *
     * @return string
     */
    public static function getLang(): string
    {
        return Client::getInstance()->getLang();
    }
}