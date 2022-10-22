<?php

namespace BugrovWeb\YandexSchedule;

class AllAvailableStations
{
    /**
     * Список всех доступных станций
     *
     * @return array
     * @throws \Exception
     */
    public function getData(): array
    {
        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_STATIONS_LIST));
    }
}