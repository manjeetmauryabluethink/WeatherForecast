<?php

declare(strict_types=1);

namespace Bluethinkinc\WeatherForecast\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\Request as GuzzleHttpRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;

/**
 * Class ApiClient
 */
class ApiClient
{
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://api.openweathermap.org/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = 'data/2.5/weather?';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Fetch some data from API
     */
    public function execute(): void
    {
        $response = $this->doRequest(static::API_REQUEST_ENDPOINT);
        $status = $response->getStatusCode(); // 200 status code
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents(); // here you will have the API response in JSON format
        echo "<pre>";
        print_r($responseContent);
        // Add your logic using $responseContent
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);

        $headers = [
            'content-type' => 'application/json'
        ];
        try {
            $response = $client->send(
                new GuzzleHttpRequest(
                    $requestMethod,
                    'https://api.openweathermap.org/data/2.5/weather?q=Noida,in&appid=9dc824ef1bdd4e80ab406c817d1649c9',
                    $headers
                )
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
