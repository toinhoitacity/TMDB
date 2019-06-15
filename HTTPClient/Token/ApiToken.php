<?php

/**
 * This class returns a string token
 *
 * @package Mundipagg\Tmdb\HTTPClient\Token
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\HTTPClient\Token;

use Mundipagg\Tmdb\Helper\Data;

class ApiToken implements ApiTokenInterface
{
    /**
     * @var string
     */
    protected $apiToken = null;

    /**
     * @var \Mundipagg\Tmdb\Helper\Data
     */
    private $helperData;

    /**
     * Token construct
     *
     * @param string $api_token
     */
    public function __construct(Data $helperData)
    {
        $this->apiToken = $helperData->getGeneralConfig("api_key");
    }

    /**
     * @param  string $apiToken
     * @return Mundipagg\Tmdb\HTTPClient\Token\ApiTokenInterface $this
     */
    public function setToken(string $apiToken): ApiTokenInterface
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return (!empty($this->apiToken))? $this->apiToken : ApiTokenInterface::API_TOKEN;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->apiToken;
    }
}