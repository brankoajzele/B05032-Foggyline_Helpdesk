<?php

namespace Foggyline\Helpdesk\Controller\Ticket;

class Index extends \Foggyline\Helpdesk\Controller\Ticket
{
    /**
     * Render Ticket entities listing and New Ticket form
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Helpdesk Tickets'));
        $this->_view->renderLayout();
    }
}