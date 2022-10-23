<?php

    use App\Controller\OpenExchangeApi;
    use GuzzleHttp\Client;

    require '../vendor/autoload.php';
    $config = require '../config.php';
    $appId = $config['app_id'];

    $openExchange = new OpenExchangeApi($appId, new Client());

    try {
        var_dump($openExchange->fetchRate(['UAH', 'RUB']));
    } catch (JsonException $e) {
        echo $e->getMessage();
    }