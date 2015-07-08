<?php

namespace Foggyline\Helpdesk\Model\Resource;

class Ticket extends \Magento\Framework\Model\Resource\Db\AbstractDb
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