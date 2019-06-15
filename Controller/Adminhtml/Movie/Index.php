<?php

/**
 * This class is a Controller to TMDB module
 *
 * @package Toinhoitacity\Tmdb\Controller\Adminhtml\Movie
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Toinhoitacity\Tmdb\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Backend\App\Action\Context;

class Index extends Action
{
    protected $resultFactory;

    /**
     * Index constructor.
     *
     * @param  \Magento\Backend\App\Action\Context $context
     * @param  Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->resultFactory = $pageFactory;
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
        $page = $this->resultFactory->create();

        return $page;
    }

    /**
     * Checking if the user has access to requested component.
     *
     * @inheritDoc
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Toinhoitacity_Tmdb::tmdb_movies');
    }
}