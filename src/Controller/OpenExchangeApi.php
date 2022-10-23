<?php

    namespace App\Controller;

    use App\Model\Rate;
    use DateTime;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\GuzzleException;
    use JsonException;
    use RuntimeException;

    class OpenExchangeApi
    {
        private string $appId;
        private Client $client;

        private const API_URL = 'https://openexchangerates.org/api/';


        public function __construct(string $appId, Client $client)
        {
            $this->appId = $appId;
            $this->client = $client;
        }

        /**
         * fetch rate from open exchange
         *
         * @param array|null $symbols
         *
         * @return Rate
         * @throws JsonException
         */

        public function fetchRate(?array $symbols): Rate
        {
            $url = self::API_URL . 'latest.json?app_id=' . $this->appId;
            if ($symbols) {
                $url .= '&symbols=' . implode(',', $symbols);
            }

            $content = $this->fetchContent($url);

            $date = new DateTime();
            $date->setTimestamp($content['timestamp']);

            return new Rate($content['rates'], $date);

        }

        /**
         * Fetches the content of the given url.
         *
         * @param string $url
         *
         * @return array
         *
         * @throws JsonException
         */
        protected function fetchContent(string $url): array
        {
            $client = $this->client;
            try {
                $response = $client->get($url);
            } catch (GuzzleException $e) {
                throw new RuntimeException('Error', $e->getCode(), $e);
            }

            if($response->getStatusCode() !== 200) {
                throw new RuntimeException('Error');
            }
            return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        }
    }