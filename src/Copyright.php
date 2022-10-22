<?php

namespace BugrovWeb\YandexSchedule;

class Copyright
{
    /**
     * Копирайт Яндекс.Расписаний
     *
     * @return array
     * @throws \Exception
     */
    public function getData(): array
    {
        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_COPYRIGHT));
    }
}