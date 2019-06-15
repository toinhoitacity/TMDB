<?php

/**
 * This class is a Controller to TMDB module
 *
 * @package Mundipagg\Tmdb\Controller\Adminhtml\Movie
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Backend\App\Action\Context;
use Mundipagg\Tmdb\Api\TmdbRepositoryInterface;
use Mundipagg\Tmdb\WebService\TmdbWebServiceInterface;
use Mundipagg\Tmdb\Api\Data\TmdbInterface;

class Save extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $resultFactory
     */
    protected $resultFactory;
    
    /**
     * @var Mundipagg\Tmdb\Api\TmdbRepositoryInterface $tmdbRepository
     */
    private $tmdbRepository;
    
    /**
     * @var \Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $tmdbWebService
     */
    private $tmdbWebService;
    
    /**
     * @var \Mundipagg\Tmdb\Api\Data\TmdbInterface $tmdb
     */
    private $tmdb;

    /**
     * Index constructor.
     *
     * @param  \Magento\Backend\App\Action\Context $context
     * @param  \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param  Mundipagg\Tmdb\Api\TmdbRepositoryInterface $tmdbRepository
     * @param  Mundipagg\Tmdb\WebService\TmdbWebServiceInterface $tmdbWebService
     * @param  Mundipagg\Tmdb\Api\Data\TmdbInterface $tmdb
     */
    public function __construct(Context $context, PageFactory $pageFactory, TmdbRepositoryInterface $tmdbRepository, TmdbWebServiceInterface $tmdbWebService, TmdbInterface $tmdb)
    {
        parent::__construct($context);
        $this->resultFactory = $pageFactory;
        $this->tmdbRepository = $tmdbRepository;
        $this->tmdbWebService = $tmdbWebService;
        $this->tmdb = $tmdb;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        //$page = $this->resultFactory->create();
        $this->saveProduct();

        return $page;
    }
    
    /**
     * Save movie as a product
     *
     * @return TmdbInterface
     */
    private function saveProduct()
    {
        //try {
            $this->tmdbRepository->save($this->getMovie());
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('mundipagg_tmdb/movie/index');
        /*} catch (\Exception $err) {
            $page = $this->resultFactory->create();
            $page->setActiveMenu('TMDB_AdminController::all_movies');
            $page->getLayout()->initMessages();
            $page->getLayout()->getBlock('tmdb.index')->setErrors($this->tmdbRepository->errors);
            return $page;
        }*/
    }
    
    /**
     * Get Movie. API Send request
     *
     * @return TmdbInterface
     */
    public function getMovie(): TmdbInterface
    {
        $tmdb_id = $this->getRequest()->getParam('tmdb_product');
        $response = $this->tmdb;
        
        if (!empty($tmdb_id)) {
            $this->tmdbWebService->setMethodUrl("movie/". $tmdb_id);

            $response = $this->tmdbWebService->sendRequestSingleMovie();
        }
        
        return $response;
    }


    /**
     * Checking if the user has access to requested component.
     *
     * @inheritDoc
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Mundipagg_Tmdb::tmdb_movies');
    }
}