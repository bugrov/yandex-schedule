<?php

namespace BugrovWeb\YandexSchedule;

class ListOfNearestStations
{
    /**
     * Список ближайших станций
     *
     * @param string $lat Широта
     * @param string $lng Долгота
     * @param int $distance Радиус, в котором следует искать станции, в километрах
     * @param int $offset Смещение относительно первого результата поиска
     * @param int $limit Максимальное количество результатов поиска в ответе
     * @param string|null $stationTypes Типы запрашиваемых станций (несколько типов можно перечислить через запятую)
     * @param string|null $transportTypes Типы транспортного средства, для которых нужно искать станции.
     * Несколько типов одновременно можно указать через запятую
     * @return array
     * @throws \Exception
     */
    public function getData(string $lat, string $lng, int $distance, int $offset = 0, int $limit = 100,
                            string $stationTypes = null, string $transportTypes = null): array
    {
        $query = [
            'lat'             => $lat,
            'lng'             => $lng,
            'distance'        => $distance,
            'station_types'   => $stationTypes,
            'transport_types' => $transportTypes,
            'offset'          => $offset,
            'limit'           => $limit,
        ];

        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_NEAREST_STATIONS, $query));
    }
}