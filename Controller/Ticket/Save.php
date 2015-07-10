<?php

namespace Foggyline\Helpdesk\Controller\Ticket;

class Save extends \Foggyline\Helpdesk\Controller\Ticket
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;
    protected $formKeyValidator;
    protected $dateTime;
    protected $ticketFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Foggyline\Helpdesk\Model\TicketFactory $ticketFactory
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->dateTime = $dateTime;
        $this->ticketFactory = $ticketFactory;
        $this->messageManager = $context->getMessageManager();
        parent::__construct($context, $customerSession);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $resultRedirect->setRefererUrl();
        }

        $title = $this->getRequest()->getParam('title');
        $severity = $this->getRequest()->getParam('severity');

        try {
            /* Save ticket */
            $ticket = $this->ticketFactory->create();
            $ticket->setCustomerId($this->customerSession->getCustomerId());
            $ticket->setTitle($title);
            $ticket->setSeverity($severity);
            $ticket->setCreatedAt($this->dateTime->formatDate(true));
            $ticket->setStatus(\Foggyline\Helpdesk\Model\Ticket::STATUS_OPENED);
            $ticket->save();

            $customer = $this->customerSession->getCustomerData();

            /* Send email to store owner */
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->scopeConfig->getValue('foggyline_helpdesk/email_template/store_owner', $storeScope))
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars(['ticket' => $ticket])
                ->setFrom([
                    'name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
                    'email' => $customer->getEmail()
                ])
                ->addTo($this->scopeConfig->getValue('trans_email/ident_general/email', $storeScope))
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();

            $this->messageManager->addSuccess(__('Ticket successfully created.'));
        } catch (Exception $e) {
            $this->messageManager->addError(__('Error occurred during ticket creation.'));
        }

        return $resultRedirect->setRefererUrl();
    }
}