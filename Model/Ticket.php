<?php

namespace Foggyline\Helpdesk\Model;

class Ticket extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_OPENED = 1;
    const STATUS_CLOSED = 2;

    const SEVERITY_LOW = 1;
    const SEVERITY_MEDIUM = 2;
    const SEVERITY_HIGH = 3;

    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Foggyline\Helpdesk\Model\Resource\Ticket');
    }
}