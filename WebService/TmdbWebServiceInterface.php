<?php

/**
 * Web Service Interface
 *
 * @package Mundipagg\Tmdb\WebService
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\WebService;

use Zend\Stdlib\Parameters;

interface TmdbWebServiceInterface
{
    const IMAGE_BASE_URL = "https://image.tmdb.org/t/p/w300";

    /**
     * Returns uri string
     *
     * @return stringt
     */
    public function getURI(): string;

    /**
     * Add custom parameters to send with API request
     *
     * @param string $data
     * @return \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $this
     */
    public function setMethodUrl($methodUrl): TmdbWebServiceInterface;

    /**
     * Add custom parameters
     *
     * @param array $params
     * @return \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $this
     */
    public function addParams(array $params = []): TmdbWebServiceInterface;

    /**
     * Add custom parameters with key and value
     *
     * @param string $key
     * @param string $value
     * @return \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $this
     */
    public function addParamsByKeyAndValue(string $key, string $value): TmdbWebServiceInterface;

    /**
     * Get Parameters instance to customParam attribute
     *
     * @return Zend\Stdlib\Parameters
     */
    public function getCustomParam(): Parameters;

    /**
     * Get customParam attribute class
     *
     * @return array
     */
    public function getParams();
    
    /**
     * Returns Tmdb class
     *
     * @return Tmdb
     */
    public function sendRequestSingleMovie();

    /**
     * Instantiates request if necessary and sends off with collected data
     *
     * @return mixed
     */
    public function sendRequest();
}