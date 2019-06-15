<?php

/**
 * Index Block Class
 *
 * @package Mundipagg\Tmdb\Block\Adminhtml
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Block\Adminhtml;

use Magento\Framework\View\Element\Template;
use \Magento\Backend\Block\Template\Context;
use Mundipagg\Tmdb\WebService\TmdbWebServiceInterface;
use \Magento\Framework\UrlInterface;

class Show extends Template
{
    /**
     * @var \Magento\Framework\UrlInterface $makeUrl
     */
    private $makeUrl;

    /**
     * @var \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $tmdbWebService
     */
    private $tmdbWebService;


    /**
     * Show constructor.
     *
     * @param Context $context
     * @param TmdbWebServiceInterface $tmdbWebService
     */
    public function __construct(
        Context $context,
        TmdbWebServiceInterface $tmdbWebService,
        UrlInterface $makeUrl
    )
    {
        $this->makeUrl = $makeUrl;
        $this->tmdbWebService = $tmdbWebService;
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
        return TmdbWebServiceInterface::IMAGE_BASE_URL . "/" . $poster_path;
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