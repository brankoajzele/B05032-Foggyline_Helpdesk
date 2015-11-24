<?php

namespace Foggyline\Helpdesk\Controller\Adminhtml\Ticket;

class Close extends \Foggyline\Helpdesk\Controller\Adminhtml\Ticket
{
    protected $ticketFactory;
    protected $customerRepository;
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Foggyline\Helpdesk\Model\TicketFactory $ticketFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->ticketFactory = $ticketFactory;
        $this->customerRepository = $customerRepository;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        parent::__construct($context, $resultPageFactory, $resultForwardFactory);
    }

    public function execute()
    {
        $ticketId = $this->getRequest()->getParam('id');
        $ticket = $this->ticketFactory->create()->load($ticketId);

        if ($ticket && $ticket->getId()) {
            try {
                $ticket->setStatus(\Foggyline\Helpdesk\Model\Ticket::STATUS_CLOSED);
                $ticket->save();
                $this->messageManager->addSuccess(__('Ticket successfully closed.'));

                /* Send email to customer */
                $customer = $this->customerRepository->getById($ticket->getCustomerId());
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($this->scopeConfig->getValue('foggyline_helpdesk/email_template/customer', $storeScope))
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                            'store' => $this->storeManager->getStore()->getId(),
                        ]
                    )
                    ->setTemplateVars([
                        'ticket' => $ticket,
                        'customer_name' => $customer->getFirstname()
                    ])
                    ->setFrom([
                        'name' => $this->scopeConfig->getValue('trans_email/ident_general/name', $storeScope),
                        'email' => $this->scopeConfig->getValue('trans_email/ident_general/email', $storeScope)
                    ])
                    ->addTo($customer->getEmail())
                    ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
                $this->messageManager->addSuccess(__('Customer notified via email.'));

            } catch (Exception $e) {
                $this->messageManager->addError(__('Error with closing ticket action.'));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        return $resultRedirect;
    }
}
