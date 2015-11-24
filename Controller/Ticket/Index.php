<?php

namespace Foggyline\Helpdesk\Controller\Ticket;

class Index extends \Foggyline\Helpdesk\Controller\Ticket
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        return $resultPage;
    }
}