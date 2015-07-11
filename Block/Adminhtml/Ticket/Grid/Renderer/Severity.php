<?php

namespace Foggyline\Helpdesk\Block\Adminhtml\Ticket\Grid\Renderer;

class Severity extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $ticketFactory;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Foggyline\Helpdesk\Model\TicketFactory $ticketFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->ticketFactory = $ticketFactory;
    }

    public function render(\Magento\Framework\Object $row)
    {
        $ticket = $this->ticketFactory->create()->load($row->getId());

        if ($ticket && $ticket->getId()) {
            return $ticket->getSeverityAsLabel();
        }

        return '';
    }
}
