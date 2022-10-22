<?php

namespace BugrovWeb\YandexSchedule;

class CarrierInfo
{
    /**
     * Информация о перевозчике
     *
     * @param string $code
     * @param string $system
     * @return array
     * @throws \Exception
     */
    public function getData(string $code, string $system = Transport::SYSTEM_TYPE_YANDEX): array
    {
        $query = [
            'code'   => $code,
            'system' => $system
        ];

        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_CARRIER, $query));
    }
}