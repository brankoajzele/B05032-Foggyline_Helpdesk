<?php

namespace Foggyline\Helpdesk\Model\Ticket\Grid;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return \Foggyline\Helpdesk\Model\Ticket::getStatusesOptionArray();
    }
}
