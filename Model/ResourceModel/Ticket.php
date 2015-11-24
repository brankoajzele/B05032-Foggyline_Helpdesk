<?php

namespace Foggyline\Helpdesk\Model\ResourceModel;

class Ticket extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     * Get table name from config
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('foggyline_helpdesk_ticket', 'ticket_id');
    }
}