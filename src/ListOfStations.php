<?php

namespace BugrovWeb\YandexSchedule;

class ListOfStations
{
    /**
     * Список станций следования
     *
     * @param string $uid Идентификатор нитки в Яндекс.Расписаниях
     * @param string|null $showSystems Система кодирования, в которой необходимо получить коды станций
     * @param string|null $date Дата, на которую необходимо получить список станций следования
     * @param string|null $from Код станции отправления
     * @param string|null $to Код станции прибытия
     * @return array
     * @throws \Exception
     */
    public function getData(string $uid, string $showSystems = null, string $date = null,
                            string $from = null, string $to = null): array
    {
        $query = [
            'uid' => $uid,
            'from' => $from,
            'to' => $to,
            'date' => $date,
            'show_systems' => $showSystems
        ];

        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_THREAD, $query));
    }
}