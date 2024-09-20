<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Random\Randomizer;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Exception\RequestException;

class AIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {


// Handler Stack erstellen
$stack = HandlerStack::create();

// Retry-Middleware definieren
$retryMiddleware = Middleware::retry(
    // Retry-Bedingungen
    function ($retries, $request, $response, $exception) {
        // Maximale Anzahl von Wiederholungen
        if ($retries >= 5) {
            return false;
        }

        // Bei Serverfehlern (5xx) wiederholen
        if ($response && $response->getStatusCode() >= 500) {
            return true;
        }

        // Bei Verbindungsfehlern wiederholen
        if ($exception instanceof RequestException && $exception->getCode() === 0) {
            return true;
        }

        return false;
    },
    // Angepasste Verzögerungsfunktion
    function ($retries) {
        // Hier können Sie Ihre eigene Verzögerungslogik implementieren
        // Beispiel: Feste Verzögerung von 2 Sekunden
        return 2000; // 2000 Millisekunden = 2 Sekunden

        // Oder eine andere Logik, z.B. linear ansteigende Verzögerung:
        // return $retries * 1000; // 1 Sekunde, 2 Sekunden, 3 Sekunden, ...

        // Oder eine benutzerdefinierte Logik:
        // return min(pow(2, $retries) * 1000, 60000); // Exponentieller Backoff mit max. 60 Sekunden
    }
);

// Retry-Middleware zum Handler Stack hinzufügen
$stack->push($retryMiddleware);

// Guzzle-Client mit angepasstem Handler Stack erstellen
$client = new Client(['handler' => $stack]);




        $this->client = new Client([
            'handler' => $stack,
            'base_uri' => 'https://api-inference.huggingface.co/models/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
            ],
            'timeout' => 60
        ]);

        $this->apiKey = config('services.huggingface.api_key');
    }

    public function generateText($prompt, $model = null)
    {
        /*$response = $this->client->post($model ?? config('services.huggingface.model'),
        [
            'json' => [
                    'inputs' => $prompt,
                    'parameters' => [
                        'max_new_tokens' => 200,
                        'temperature' => 0.7,
                        'top_p' => 0.95,
                        'do_sample' => true,
                        'repetition_penalty' => 1.1 + (new Randomizer())->getFloat(0, 0.8)
                     ]
                ]
        ]
    );


        [
            'json' => [
            'inputs' => $prompt,
            'parameters' => [
                'max_new_tokens' => 200,
                'temperature' => 0.7,
                'top_p' => 0.95,
                'do_sample' => true,
                'repetition_penalty' => 1.1 + (new Randomizer())->getFloat(0, 0.8)
             ]
            ]
        ],);

        return str_replace($prompt, "", json_decode($response->getBody(), true)[0]['generated_text']);
        */
        $faker = \Faker\Factory::create();
        $words = [];
        for ($i = 0; $i < 15; $i++) {
            array_push($words, $faker->userName);
        }
        return $words;

    }
}
