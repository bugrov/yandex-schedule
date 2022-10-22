<?php

namespace BugrovWeb\YandexSchedule;

class ScheduleOfFlightsByStation
{
    /**
     * Расписание рейсов по станции
     *
     * @param string $station Код станции
     * @param string $system Система кодирования, в которой указывается код станции
     * @param string $showSystems Система кодирования, в которой необходимо получить коды станций
     * @param string|null $date Дата, на которую необходимо получить список рейсов
     * @param string|null $transportTypes Тип транспортного средства
     * @param string|null $direction Код направления, по которому необходимо получить список рейсов электричек по станции
     * @param string $event Событие, для которого нужно отфильтровать нитки в расписании
     * @return array
     * @throws \Exception
     */
    public function getData(string $station, string $system = Transport::SYSTEM_TYPE_YANDEX,
                            string $showSystems = Transport::SYSTEM_TYPE_YANDEX, string $date = null,
                            string $transportTypes = null, string $direction = null,
                            string $event = Transport::EVENT_TYPE_DEPARTURE): array
    {
        $query = [
            'station'         => $station,
            'date'            => $date,
            'transport_types' => $transportTypes,
            'direction'       => $direction,
            'event'           => $event,
            'system'          => $system,
            'show_systems'    => $showSystems,
        ];

        $client = Client::getInstance();

        return $client->getResponse($client->getRequestURL(Transport::API_TYPE_SCHEDULE, $query));
    }
}