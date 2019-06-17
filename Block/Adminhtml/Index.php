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
use Toinhoitacity\Tmdb\Api\Data\TmdbInterface;
use Toinhoitacity\Tmdb\WebService\TmdbWebServiceInterface;
use Toinhoitacity\Tmdb\Api\TmdbRepositoryInterface;
use Toinhoitacity\Tmdb\HTTPClient\Image\ImageUriInterface;
use \Magento\Framework\UrlInterface;
use \Zend\Http\Request;

class Index extends Template
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
     * @var \Toinhoitacity\Tmdb\Api\TmdbRepositoryInterface $tmdbRepository
     */
    private $tmdbRepository;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var \Toinhoitacity\Tmdb\Api\Data\TmdbInterface $tmdb
     */
    private $tmdb;

    /**
     * @var \Toinhoitacity\Tmdb\HTTPClient\Image\ImageUriInterface $imageUri
     */
    private $imageUri;

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
        TmdbInterface $tmdb,
        ImageUriInterface $imageUri,
        Request $request
    )
    {
        $this->makeUrl = $makeUrl;
        $this->tmdbWebService = $tmdbWebService;
        $this->tmdbRepository = $tmdbRepository;
        $this->tmdb = $tmdb;
        $this->request = $request;
        $this->imageUri = $imageUri;
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
     * Returns Tmdb class
     *
     * @param stdClass $obj
     * @return Tmdb
     */
    public function objToTmdb($obj)
    {
        $this->tmdb->setTmdb($obj);
        return $this->tmdb;
    }

}