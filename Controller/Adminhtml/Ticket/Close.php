<?php

namespace Foggyline\Helpdesk\Controller\Adminhtml\Ticket;

use Symfony\Component\Config\Definition\Exception\Exception;

class Close extends \Foggyline\Helpdesk\Controller\Adminhtml\Ticket
{
    protected $ticketFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Foggyline\Helpdesk\Model\TicketFactory $ticketFactory
    )
    {
        $this->ticketFactory = $ticketFactory;
        parent::__construct($context, $resultPageFactory, $resultForwardFactory);
    }

    public function execute()
    {
        $tickedId = $this->getRequest()->getParam('id');
        $ticked = $this->ticketFactory->create()->load($tickedId);

        if ($ticked && $ticked->getId()) {
            try {
                $ticked->setStatus(\Foggyline\Helpdesk\Model\Ticket::STATUS_CLOSED);
                $ticked->save();

                $this->messageManager->addSuccess(__('Ticket successfully closed.'));
            } catch (Exception $e) {
                $this->messageManager->addError(__('Error closing ticket.'));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        return $resultRedirect;
    }
}
