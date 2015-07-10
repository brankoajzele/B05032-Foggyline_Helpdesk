<?php

namespace Foggyline\Helpdesk\Controller\Adminhtml;

class Ticket extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        parent::__construct($context);
    }

    /**
     * Check if user has enough privileges
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Foggyline_Helpdesk::ticket_manage');
    }

    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Foggyline_Helpdesk::ticket_manage'
        )->_addBreadcrumb(
            __('Helpdesk'),
            __('Tickets')
        );
        return $this;
    }
}
