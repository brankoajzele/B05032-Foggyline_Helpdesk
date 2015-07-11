<?php

namespace Foggyline\Helpdesk\Block\Adminhtml;

class Ticket extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'Foggyline_Helpdesk';
        $this->_headerText = __('Tickets');

        parent::_construct();

        $this->removeButton('add');
    }
}
