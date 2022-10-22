# PHP SDK для работы с API Яндекс.Расписаний

## Установка

Поддерживается установка с помощью [менеджера пакетов](https://getcomposer.org).

```
$ composer require bugrov/yandex-schedule
```

Или

```
$ php composer.phar require arhitector/yandex-schedule
```

## Как подключиться к Яндекс.Расписаниям

Перед использованием доступных методов вызываем метод `setApiKey`, передав в него API-ключ

```php
\BugrovWeb\YandexSchedule\Transport::setApiKey('your-api-key');
```

## Настройка и получение параметров

### Метод setApiKey

Устанавливает ключ для доступа к API Яндекс станций

```php
public static function setApiKey(string $apiKey)
```

`$apiKey` - ключ API (подробнее о его получении [тут](https://yandex.ru/dev/rasp/doc/concepts/access.html))

**Пример использования**

```php
\BugrovWeb\YandexSchedule\Transport::setApiKey('your-api-key');
```

### Метод getApiKey

Получает ранее установленный ключ API

```php
public static function getApiKey()
```

**Пример использования**

```php
echo \BugrovWeb\YandexSchedule\Transport::getApiKey();
```

### Метод setFormat

Устанавливает формат возвращаемых данных

```php
public static function setFormat(string $format)
```

`$format` - формат возвращаеммых данных. Допустимые значения - `json`, `xml`

**Пример использования**

```php
\BugrovWeb\YandexSchedule\Transport::setFormat('xml');
```

### Метод getFormat

Получает ранее установленный формат данных

```php
public static function getFormat()
```

**Пример использования**

```php
echo \BugrovWeb\YandexSchedule\Transport::getFormat();
```

### Метод setLang

Устанавливает язык возвращаемой информации

```php
public static function setLang(string $lang)
```

`$lang` - код языка в формате <код языка>_<код страны>. Доступные значения - `ru_RU` и `uk_UA`

**Пример использования**

```php
\BugrovWeb\YandexSchedule\Transport::setLang('ru_RU');
```

### Метод getLang

Получает ранее установленный язык возвращаемой информации

```php
public static function getLang()
```

**Пример использования**

```php
echo \BugrovWeb\YandexSchedule\Transport::getLang();
```

## Работа с Яндекс.Расписанием

### Метод getScheduleBetweenStations

Получает список рейсов, следующих от указанной станции отправления к указанной станции прибытия и информацию по каждому
рейсу

```php
public static function getScheduleBetweenStations(string $from, string $to, string $system = Transport::SYSTEM_TYPE_YANDEX,
                                   string $showSystems = Transport::SYSTEM_TYPE_YANDEX, string $date = null,
                                   string $transportTypes = null, int $offset = 0, int $limit = 100,
                                   bool $addDaysMask = false, bool $transfers = false)
```

- `$from` - Код станции отправления. Должен быть указан
  в [системе кодирования](https://yandex.ru/dev/rasp/doc/concepts/coding-system.html)
- `$to` - Код станции прибытия. Должен быть указан
  в [системе кодирования](https://yandex.ru/dev/rasp/doc/concepts/coding-system.html)
- `$system` - Система кодирования, в которой указывается код станции отправления и код станции прибытия (параметры from,
  to) в запросе. Возможные значения:
    - `yandex` либо `Transport::SYSTEM_TYPE_YANDEX` (значение по умолчанию)
    - `iata` либо `Transport::SYSTEM_TYPE_IATA`
    - `sirena` либо `Transport::SYSTEM_TYPE_SIRENA`
    - `express` либо `Transport::SYSTEM_TYPE_EXPRESS`
    - `esr` либо `Transport::SYSTEM_TYPE_ESR`
- `$showSystems` - Система кодирования, коды которой следует добавить к описанию станций в результатах поиска (элемент
  codes, вложенный в элементы from и to). Поддерживаемые значения:
    - `yandex` либо `Transport::SYSTEM_TYPE_YANDEX` (значение по умолчанию)
    - `esr` либо `Transport::SYSTEM_TYPE_ESR`
- `$date` - Дата, на которую необходимо получить список рейсов. Необязательное
- `$transportTypes` - Тип транспортного средства. Необязательное. Возможные значения:
    - `plane` либо `Transport::TRANSPORT_TYPE_PLANE`
    - `train` либо `Transport::TRANSPORT_TYPE_TRAIN`
    - `suburban` либо `Transport::TRANSPORT_TYPE_SUBURBAN`
    - `bus` либо `Transport::TRANSPORT_TYPE_BUS`
    - `water` либо `Transport::TRANSPORT_TYPE_WATER`
    - `helicopter` либо `Transport::TRANSPORT_TYPE_HELICOPTER`
- `$offset` - Смещение относительно первого результата поиска. По умолчанию 0
- `$limit` - Максимальное количество результатов поиска в ответе. По умолчанию 100
- `$addDaysMask` - Признак, который указывает, что для каждой нитки в ответе следует вернуть календарь хождения —
  элемент schedule, вложенный в элемент segments. Поддерживаемые значения:
    - `false` - календарь возвращать не нужно (значение по умолчанию)
    - `true` - для каждой нитки следует вернуть календарь хождения
- `$transfers` - Признак, разрешающий добавить к результатам поиска маршруты с пересадками. Поддерживаемые значения:
    - `false` - в результатах поиска не должно быть маршрутов с пересадками (значение по умолчанию)
    - `true` - найденные маршруты с пересадками следует добавить к результатам поиска

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getScheduleBetweenStations('c146', 'c213'));
```

### Метод getScheduleOfFlightsByStation

Получает список рейсов, отправляющихся от указанной станции и информацию по каждому рейсу

```php
public static function getScheduleOfFlightsByStation(string $station, string $system = Transport::SYSTEM_TYPE_YANDEX,
                            string $showSystems = Transport::SYSTEM_TYPE_YANDEX, string $date = null,
                            string $transportTypes = null, string $direction = null,
                            string $event = Transport::EVENT_TYPE_DEPARTURE)
```

- `$station` - Код станции. Должен быть указан
  в [системе кодирования](https://yandex.ru/dev/rasp/doc/concepts/coding-system.html)
- `$system` - Система кодирования, в которой указывается код станции (параметр station) в запросе. Возможные значения:
    - `yandex` либо `Transport::SYSTEM_TYPE_YANDEX` (значение по умолчанию)
    - `iata` либо `Transport::SYSTEM_TYPE_IATA`
    - `sirena` либо `Transport::SYSTEM_TYPE_SIRENA`
    - `express` либо `Transport::SYSTEM_TYPE_EXPRESS`
    - `esr` либо `Transport::SYSTEM_TYPE_ESR`
- `$showSystems` - Система кодирования, в которой необходимо получить коды станций (в элементе ответа codes, вложенном в
  элемент station). Возможные значения:
    - `yandex` либо `Transport::SYSTEM_TYPE_YANDEX` (значение по умолчанию)
    - `esr` либо `Transport::SYSTEM_TYPE_ESR`
    - `all` либо `Transport::SYSTEM_TYPE_ALL`
- `$date` - Дата, на которую необходимо получить список рейсов. Необязательное
- `$transportTypes` - Тип транспортного средства. Необязательное. Возможные значения:
    - `plane` либо `Transport::TRANSPORT_TYPE_PLANE`
    - `train` либо `Transport::TRANSPORT_TYPE_TRAIN`
    - `suburban` либо `Transport::TRANSPORT_TYPE_SUBURBAN`
    - `bus` либо `Transport::TRANSPORT_TYPE_BUS`
    - `water` либо `Transport::TRANSPORT_TYPE_WATER`
    - `helicopter` либо `Transport::TRANSPORT_TYPE_HELICOPTER`
- `$direction` - Код направления, по которому необходимо получить список рейсов электричек по станции (например,
  «arrival», «all» или «на Москву»)
- `$event` - Событие, для которого нужно отфильтровать нитки в расписании. Поддерживаемые значения:
    - `departure` либо `Transport::EVENT_TYPE_DEPARTURE` (по умолчанию)
    - `arrival` либо `Transport::EVENT_TYPE_ARRIVAL`

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getScheduleOfFlightsByStation('s9600213'));
```

### Метод getListOfStations

Получает список станций следования нитки по указанному идентификатору нитки, информацию о каждой нитке и о промежуточных
станциях нитки

```php
public static function getListOfStations(string $uid, string $showSystems = null, string $date = null,
                            string $from = null, string $to = null)
```

- `$uid` - Идентификатор нитки в Яндекс.Расписаниях
- `$showSystems` - Система кодирования, в которой необходимо получить коды станций (в элементе ответа codes, вложенном в
  элемент station). Необязательное. Возможные значения:
    - `yandex` либо `Transport::SYSTEM_TYPE_YANDEX`
    - `esr` либо `Transport::SYSTEM_TYPE_ESR`
    - `all` либо `Transport::SYSTEM_TYPE_ALL`
- `$date` - Дата, на которую необходимо получить список рейсов. Необязательное
- `$from` - Код станции отправления. Должен быть указан
  в [системе кодирования](https://yandex.ru/dev/rasp/doc/concepts/coding-system.html)
- `$to` - Код станции прибытия. Должен быть указан
  в [системе кодирования](https://yandex.ru/dev/rasp/doc/concepts/coding-system.html)

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getListOfStations('932X_1_2'));
```

### Метод getListOfNearestStations

Получает список станций, находящихся в указанном радиусе от указанной точки. Максимальное количество возвращаемых
станций — 50

```php
public static function getListOfNearestStations(string $lat, string $lng, int $distance, int $offset = 0, int $limit = 100,
                            string $stationTypes = null, string $transportTypes = null)
```

- `$lat` - Широта
- `$lng` - Долгота
- `$distance` - Радиус, в котором следует искать станции, в километрах
- `$offset` - Смещение относительно первого результата поиска. По умолчанию 0
- `$limit` - Максимальное количество результатов поиска в ответе. По умолчанию 100
- `$stationTypes` - Типы запрашиваемых станций (несколько типов можно перечислить через запятую). Необязательное.
  Поддерживаемые значения:
    - `station` - станция
    - `platform` - платформа
    - `stop` - остановочный пункт
    - `checkpoint` - блок-пост
    - `post` - пост
    - `crossing` - разъезд
    - `overtaking_point` - обгонный пункт
    - `train_station` - вокзал
    - `airport` - аэропорт
    - `bus_station` - автовокзал
    - `bus_stop` - автобусная остановка
    - `unknown` - станция без типа
    - `port` - порт
    - `port_point` - портпункт
    - `wharf` - пристань
    - `river_port` - речной вокзал
    - `marine_station` - морской вокзал
- `$transportTypes` - Типы транспортного средства, для которых нужно искать станции. Несколько типов одновременно можно
  указать через запятую, например, plane,train,bus. Необязательное. Поддерживаемые значения:
    - `plane` либо `Transport::TRANSPORT_TYPE_PLANE`
    - `train` либо `Transport::TRANSPORT_TYPE_TRAIN`
    - `suburban` либо `Transport::TRANSPORT_TYPE_SUBURBAN`
    - `sea` либо `Transport::TRANSPORT_TYPE_SEA`
    - `river` либо `Transport::TRANSPORT_TYPE_RIVER`
    - `helicopter` либо `Transport::TRANSPORT_TYPE_HELICOPTER`

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getListOfNearestStations('50.440046', '40.4882367', 50));
```

### Метод getNearestCity

Получает информацию о ближайшем к указанной точке городе

```php
public static function getNearestCity(string $lat, string $lng, int $distance = 10)
```

- `$lat` - Широта
- `$lng` - Долгота
- `$distance` - Радиус, в котором следует искать ближайший город, в километрах (по умолчанию 10)

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getNearestCity('50.440046', '40.4882367', 50));
```

### Метод getCarrierInfo

Получает информацию о перевозчике по указанному коду перевозчика

```php
public static function getCarrierInfo(string $code, string $system = Transport::SYSTEM_TYPE_YANDEX)
```

- `$code` - Код перевозчика
- `$system` - Система кодирования, в которой указывается код перевозчика (параметр code) в запросе. Возможные значения:
    - `yandex` либо `Transport::SYSTEM_TYPE_YANDEX` (значение по умолчанию)
    - `iata` либо `Transport::SYSTEM_TYPE_IATA`
    - `sirena` либо `Transport::SYSTEM_TYPE_SIRENA`
    - `express` либо `Transport::SYSTEM_TYPE_EXPRESS`
    - `esr` либо `Transport::SYSTEM_TYPE_ESR`

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getCarrierInfo('TK', Transport::SYSTEM_TYPE_IATA));
```

### Метод getAllAvailableStations

Получает полный список станций, информацию о которых предоставляют Яндекс.Расписания

```php
public static function getAllAvailableStations()
```

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getAllAvailableStations());
```

### Метод getCopyright

Получает данные о Яндекс.Расписаниях: URL сервиса, баннер в различных цветовых представлениях и уведомительный текст

```php
public static function getCopyright()
```

**Пример использования**

```php
Transport::setApiKey('your-api-key');
dump(Transport::getCopyright());
```