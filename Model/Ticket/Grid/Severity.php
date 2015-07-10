<?php

namespace Foggyline\Helpdesk\Model\Ticket\Grid;

class Severity implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return \Foggyline\Helpdesk\Model\Ticket::getSeveritiesOptionArray();
    }
}
