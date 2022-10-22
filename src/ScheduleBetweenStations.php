<?php

namespace BugrovWeb\YandexSchedule;

class ScheduleBetweenStations
{
    /**
     * Расписание рейсов между станциями
     *
     * @param string $from Код станции отправления
     * @param string $to Код станции прибытия
     * @param string $system Система кодирования, в которой указывается код станции отправления и код станции прибытия
     * @param string $showSystems Система кодирования, коды которой следует добавить к описанию станций в результатах поиска
     * @param string|null $date Дата, на которую необходимо получить список рейсов
     * @param string|null $transportTypes Тип транспортного средства
     * @param int $offset Смещение относительно первого результата поиска
     * @param int $limit Максимальное количество результатов поиска в ответе
     * @param bool $addDaysMask Признак, который указывает, что для каждой нитки в ответе следует вернуть календарь хождения
     * @param bool $transfers Признак, разрешающий добавить к результатам поиска маршруты с пересадками
     * @return array
     * @throws \Exception
     */
    public function getData(string $from, string $to, string $system = Transport::SYSTEM_TYPE_YANDEX,
                                   string $showSystems = Transport::SYSTEM_TYPE_YANDEX, string $date = null,
                                   string $transportTypes = null, int $offset = 0, int $limit = 100,
                                   bool $addDaysMask = false, bool $transfers = false): array
    {
        $query = [
            'from'            => $from,
            'to'              => $to,
            'date'            => $date,
            'transport_types' => $transportTypes,
            'system'          => $system,
            'show_systems'    => $showSystems,
            'offset'          => $offset,
            'limit'           => $limit,
            'add_days_mask'   => $addDaysMask ? 'true' : 'false',
            'transfers'       => $transfers ? 'true' : 'false',
        ];

        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_SEARCH, $query));
    }
}