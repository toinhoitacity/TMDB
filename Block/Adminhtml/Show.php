<?php

/**
 * Index Block Class
 *
 * @package Toinhoitacity\Tmdb\Block\Adminhtml
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Toinhoitacity\Tmdb\Block\Adminhtml;

use Magento\Framework\View\Element\Template;
use \Magento\Backend\Block\Template\Context;
use Toinhoitacity\Tmdb\WebService\TmdbWebServiceInterface;
use \Magento\Framework\UrlInterface;
use Toinhoitacity\Tmdb\HTTPClient\Image\ImageUriInterface;

class Show extends Template
{
    /**
     * @var \Magento\Framework\UrlInterface $makeUrl
     */
    private $makeUrl;

    /**
     * @var \Toinhoitacity\Tmdb\WebService\TmdbWebServiceInterface $tmdbWebService
     */
    private $tmdbWebService;

    /**
     * @var \Toinhoitacity\Tmdb\HTTPClient\Image\ImageUriInterface $imageUri
     */
    private $imageUri;

    /**
     * Show constructor.
     *
     * @param Context $context
     * @param TmdbWebServiceInterface $tmdbWebService
     */
    public function __construct(
        Context $context,
        TmdbWebServiceInterface $tmdbWebService,
        UrlInterface $makeUrl,
        ImageUriInterface $imageUri
    )
    {
        $this->makeUrl = $makeUrl;
        $this->tmdbWebService = $tmdbWebService;
        $this->imageUri = $imageUri;
        parent::__construct($context);
    }


    /**
     * Get Movie. API Send request
     *
     * @return stdClass
     */
    public function getMovie()
    {
        $tmdb_id = $this->getRequest()->getParam('tmdb_id');
        $response = "";
        if (!empty($tmdb_id)) {
            $this->tmdbWebService->setMethodUrl("movie/". $tmdb_id);

            $response = $this->tmdbWebService->sendRequestSingleMovie();
        }

        return $response;
    }

    /**
     * Get Base URL
     *
     * @return string
     */
    public function getImageBaseUrl($poster_path): string
    {
        return $this->imageUri->setImageUri($poster_path)->getImageUri();
    }

    /**
     * Make URL
     *
     * @return string
     */
    public function getMakeUrl($path, $params = [])
    {
        return $this->makeUrl->getUrl($path, $params);
    }

    /**
     * Check is a single Movie
     *
     * @return bool
     */
    public function isSingleMovie(): bool
    {
        $tmdb_id = $this->getRequest()->getParam('tmdb_id');

        if (!empty($tmdb_id)) {
            return true;
        }
        return false;
    }
}