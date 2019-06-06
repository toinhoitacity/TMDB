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
use Mundipagg\Tmdb\Api\Data\TmdbInterface;
use Mundipagg\Tmdb\WebService\TmdbWebServiceInterface;
use Mundipagg\Tmdb\Api\TmdbRepositoryInterface;
use \Magento\Framework\UrlInterface;
use \Zend\Http\Request;

class Index extends Template
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
     * @var \Mundipagg\Tmdb\Api\TmdbRepositoryInterface $tmdbRepository
     */
    private $tmdbRepository;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \Mundipagg\Tmdb\Api\Data\TmdbInterface $tmdbRepository
     */
    private $tmdb;


    /**
     * Index constructor.
     *
     * @param Context $context
     * @param TmdbWebServiceInterface $tmdbWebService
     * @param TmdbRepositoryInterface $tmdbRepository
     */
    public function __construct(
        Context $context,
        TmdbWebServiceInterface $tmdbWebService,
        TmdbRepositoryInterface $tmdbRepository,
        UrlInterface $makeUrl,
        Request $request,
        TmdbInterface $tmdb
    )
    {
        $this->makeUrl = $makeUrl;
        $this->tmdbWebService = $tmdbWebService;
        $this->tmdbRepository = $tmdbRepository;
        $this->request = $request;
        $this->tmdb = $tmdb;
        parent::__construct($context);
    }

    /**
     * Get Movies. API Send request
     *
     * @return array
     */
    public function getMovie()
    {
        if ($this->getRequest()->getParam('search_tmdb')) {
            $this->tmdbWebService->setMethodUrl("search/movie");
            return $this->getCustomSearch();
        }else{
            $this->tmdbWebService->setMethodUrl("discover/movie");
            return $this->getInitialSearch();
        }
    }

    /**
     * Get Movies. API Send request
     *
     * @return array
     */
    public function getInitialSearch()
    {
        $this->tmdbWebService->addParams([
            "sort_by" =>  "popularity.desc",
            "include_adult" =>  "false",
            "include_video" =>  "false"
        ]);
        return $this->tmdbWebService->sendRequest();
    }

    /**
     * Get Movies. API Send request
     *
     * @return array
     */
    public function getCustomSearch()
    {
        $this->tmdbWebService->addParams([
            "sort_by" =>  "popularity.desc",
            "include_adult" =>  "false",
            "include_video" =>  "false",
            "query" =>  $this->getRequest()->getParam('search_tmdb')
        ]);
        return $this->tmdbWebService->sendRequest();
    }

    /**
     * Get Movies. API Send request
     *
     * @return string
     */
    public function getPersonalSearch()
    {
        return $this->getRequest()->getParam('search_tmdb');
    }

    public function getRequestParams($key): string
    {
        return $this->getRequest()->getParam($key);
    }

    public function singleMovie()
    {
        $tmdb_id = $this->getRequest()->getParam('tmdb_id');
        $response = "";
        if (!empty($tmdb_id)) {
            $this->tmdbWebService->setMethodUrl("movie/". $tmdb_id);

            $response = $this->tmdbWebService->sendRequest();
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