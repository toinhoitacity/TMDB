<?php

/**
 * Web Service Class
 *
 * @package Mundipagg\Tmdb\WebService
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\WebService;

use Zend\Http\Headers;
use \Zend\Http\Request;
use \Magento\Framework\HTTP\ZendClient;
use \Zend\Http\Client;
use Mundipagg\Tmdb\Helper\Data;
use Mundipagg\Tmdb\HTTPClient\Token\ApiTokenInterface;
use Zend\Stdlib\Parameters;

class TmdbWebService implements TmdbWebServiceInterface
{
    const API_BASE_URL = "https://api.themoviedb.org/3/";
    const SKU_PREFIX = "tmdb-";

    /**
     * @var string
     */
    protected $methodUrl;

    /**
     * Parameters to be sent
     *
     * @var array
     */
    private $customParam;

    /**
     * TmdbWebService constructor.
     *
     * @param \Zend\Http\Request $request
     * @param Zend\Http\Client $client
     * @param Mundipagg\Tmdb\Helper\Data $helperData
     */
    public function __construct(Request $request, Client $client, ApiTokenInterface $apiToken)
    {
        $this->request = $request;
        $this->client = $client;
        $this->customParam = [
            "api_key" => $apiToken->getToken()
        ];
    }

    /**
     * Returns uri string
     *
     * @return stringt
     */
    public function getURI(): string
    {
        return self::API_BASE_URL . $this->methodUrl;
    }

    /**
     * Add custom parameters to send with API request
     *
     * @param string $methodUrl
     * @return \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $this
     */
    public function setMethodUrl($methodUrl): TmdbWebServiceInterface
    {
        $this->methodUrl = $methodUrl;
        return $this;
    }

    /**
     * Add custom parameters
     *
     * @param array $params
     * @return \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $this
     */
    public function addParams(array $params = []): TmdbWebServiceInterface
    {
        $this->customParam = array_merge($this->customParam, $params);
        return $this;
    }

    /**
     * Add custom parameters with key and value
     *
     * @param string $key
     * @param string $value
     * @return \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $this
     */
    public function addParamsByKeyAndValue(string $key, string $value): TmdbWebServiceInterface
    {
        $this->addParams([$key => $value]);
        return $this;
    }

    /**
     * Get Parameters instance to customParam attribute
     *
     * @return Zend\Stdlib\Parameters
     */
    public function getCustomParam(): Parameters
    {
        return new Parameters($this->customParam);
    }

    /**
     * Get customParam attribute class
     *
     * @return array
     */
    public function getParams()
    {
        return $this->customParam;
    }

    /**
     * Returns HTTP request to events url
     *
     * @return \Zend\Http\Request
     */
    protected function getRequest(): Request
    {
        /** @var Headers $headers */
        $headers = new Headers();
        $headers->addHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $this->request->setHeaders($headers);

        $this->request->setUri($this->getURI());
        $this->request->setMethod(ZendClient::GET);
        $this->request->setQuery($this->getCustomParam());

        $this->client->setOptions([
            'adapter'   => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
            'maxredirects' => 0,
            'timeout' => 30
        ]);

        return $this->request;
    }

    /**
     * Instantiates request if necessary and sends off with collected data
     *
     * @return mixed
     */
    public function sendRequest()
    {
        $response = $this->client->send($this->getRequest());

        return json_decode($response->getBody());
    }

    public function getImage($imagePath = "")
    {
        if (empty($imagePath)) {
            return "http://lorempixel.com/150/225/1/No%20Poster%20Avaliable/";
        }
        return TmdbWebServiceInterface::IMAGE_BASE_URL . $imagePath;
    }
}