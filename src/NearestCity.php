<?php

namespace BugrovWeb\YandexSchedule;

class NearestCity
{
    /**
     * Ближайший город
     *
     * @param string $lat Широта
     * @param string $lng Долгота
     * @param int $distance Радиус, в котором следует искать ближайший город, в километрах
     * @return array
     * @throws \Exception
     */
    public function getData(string $lat, string $lng, int $distance = 10): array
    {
        if ($distance < 0 || $distance > 50) {
            throw new \Exception('Параметр distance должен быть числом от 0 до 50!');
        }

        $query = [
            'lat'      => $lat,
            'lng'      => $lng,
            'distance' => $distance,
        ];

        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_NEAREST_SETTLEMENT, $query));
    }
}