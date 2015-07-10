<?php

namespace Foggyline\Helpdesk\Controller\Adminhtml\Ticket;

class Grid extends \Foggyline\Helpdesk\Controller\Adminhtml\Ticket
{
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
