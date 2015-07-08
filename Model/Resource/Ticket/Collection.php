<?php

namespace Foggyline\Helpdesk\Model\Resource\Ticket;

class Collection extends \Magento\Framework\Model\Resource\Db\Collection\AbstractCollection
{
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Foggyline\Helpdesk\Model\Ticket', 'Foggyline\Helpdesk\Model\Resource\Ticket');
    }
}
