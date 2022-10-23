<?php

namespace BugrovWeb\YandexSchedule;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class Client
{
    /**
     * @var string API-ключ
     */
    private $key;

    private static ?Client $instance = null;

    /**
     * @var string формат данных
     */
    private string $format = 'json';

    /**
     * @var string язык
     */
    private string $lang = 'ru_RU';

    /**
     * Допустимые коды стран
     */
    protected array $langCompliance = [
        'ru_RU',
        'uk_UA'
    ];

    /**
     * Допустимые форматы ответа
     */
    protected array $formatCompliance = [
        'json',
        'xml'
    ];

    /**
     * URL api Яндекс.Станции
     */
    const API_BASE_URL = 'https://api.rasp.yandex.net/';

    /**
     * Версия api Яндекс.Станции
     */
    const API_VERSION = 'v3';

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Устанавливает ключ API
     *
     * @param string $apiKey ключ API
     * @return $this
     */
    public function setApiKey(string $apiKey): Client
    {
        $this->key = $apiKey;

        return $this;
    }

    /**
     * Возвращает установленный API-ключ
     *
     * @return string|null API ключ
     */
    public function getApiKey(): ?string
    {
        return $this->key;
    }

    /**
     * Возвращает формат ответа
     *
     * @return string формат возвращаеммых данных
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Получает язык возвращаемой информации, в формате <код языка>_<код страны>
     *
     * @return string язык возвращаемой информации
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * Устанавливает формат возвращаемых данных
     *
     * @param string $format формат данных
     * @return $this
     * @throws \Exception
     */
    public function setFormat(string $format): Client
    {
        if (!in_array($format, $this->formatCompliance)) {
            throw new \Exception('Формат данных не поддерживается!');
        }

        $this->format = $format;

        return $this;
    }

    /**
     * Устанавливает язык возвращаемой информации
     *
     * @param string $lang код языка
     * @return $this
     * @throws \Exception
     */
    public function setLang(string $lang): Client
    {
        if (!in_array($lang, $this->langCompliance)) {
            throw new \Exception('Код языка не поддерживается!');
        }

        $this->lang = $lang;

        return $this;
    }

    /**
     * Делает запрос к API Яндекс.Станции
     *
     * @param string $url URL запроса
     * @return array тело ответа
     * @throws ClientException
     * @throws \Exception
     */
    public function getResponse(string $url): array
    {
        $request = new HttpClient();

        try {
            $response = $request->get($url);
        } catch (ClientException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();

            if ($this->format == 'xml') {
                $xml = simplexml_load_string($response);
                $response = json_encode($xml, JSON_UNESCAPED_UNICODE);
            }

            $responseData = json_decode($response, true);

            if ($responseData['error'] && $responseData['error']['text']) {
                throw new \Exception($responseData['error']['text']);
            } else throw $exception;
        }

        if ($this->format == 'xml') {
            $xml = simplexml_load_string($response->getBody());
            $result = json_encode($xml, JSON_UNESCAPED_UNICODE);

            return json_decode($result, true);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Формирует URL для запроса к Яндекс.Станции
     *
     * @param string $type тип запроса
     * @param array $data данные для отправки
     * @return string
     */
    public function getRequestURL(string $type, array $data = []): string
    {
        $defaultParams = [
            'apikey' => $this->getApiKey(),
            'format' => $this->format,
            'lang'   => $this->lang
        ];

        $urlParams = array_merge($defaultParams, $data);

        return self::API_BASE_URL . self::API_VERSION . '/' . $type . '/?' . http_build_query($urlParams);
    }
    private function __construct(){}
    private function __clone(){}
}