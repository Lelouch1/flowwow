<?php

    use App\Controller\OpenExchangeApi;
    use App\Model\Rate;
    use GuzzleHttp\Client;

    require '../vendor/autoload.php';
    $config = require '../config.php';
    $appId = $config['app_id'];

    $openExchange = new OpenExchangeApi($appId, new Client());

    try {
         $rate = $openExchange->fetchRate(['UAH', 'RUB']);
         echo $rate->getDate() . '<br>';
         foreach ($rate->getValue() as $currency => $value) {
             echo $currency . ' ' . $value . PHP_EOL;
         }

    } catch (JsonException $e) {
        echo $e->getMessage();
    }