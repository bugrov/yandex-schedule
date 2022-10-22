<?php

use BugrovWeb\YandexSchedule\Transport;

require './vendor/autoload.php';

Transport::setApiKey('your-api-key');

//dump(Transport::getFormat(), Transport::getLang());
//dump(Transport::getScheduleBetweenStations('c146', 'c213'));
//dump(Transport::getScheduleOfFlightsByStation('s9600213'));
//dump(Transport::getListOfStations('932X_1_2'));
//dump(Transport::getListOfNearestStations('50.440046', '40.4882367', 50));
//dump(Transport::getNearestCity('50.440046', '40.4882367', 50));
//dump(Transport::getCarrierInfo('TK', Transport::SYSTEM_TYPE_IATA));
//dump(Transport::getAllAvailableStations());
dump(Transport::getCopyright());