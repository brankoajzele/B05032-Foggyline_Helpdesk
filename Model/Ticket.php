<?php

namespace Foggyline\Helpdesk\Model;

class Ticket extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_OPENED = 1;
    const STATUS_CLOSED = 2;

    const SEVERITY_LOW = 1;
    const SEVERITY_MEDIUM = 2;
    const SEVERITY_HIGH = 3;

    protected static $statusesOptions = [
        self::STATUS_OPENED => 'Opened',
        self::STATUS_CLOSED => 'Closed',
    ];

    protected static $severitiesOptions = [
        self::SEVERITY_LOW => 'Low',
        self::SEVERITY_MEDIUM => 'Medium',
        self::SEVERITY_HIGH => 'High',
    ];

    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Foggyline\Helpdesk\Model\Resource\Ticket');
    }

    public static function getSeveritiesOptionArray()
    {
        return self::$severitiesOptions;
    }

    public function getStatusAsLabel()
    {
        return self::$statusesOptions[$this->getStatus()];
    }

    public function getSeverityAsLabel()
    {
        return self::$severitiesOptions[$this->getSeverity()];
    }
}