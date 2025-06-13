<?php
/**
 * @category   Tcz
 * @package    Tcz_Enquiry
 * @author     Aditya Kumar Upadhyay <kumarupadhyayaditya59@gmail.com>
 * @copyright  Copyright (c) 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Tcz\Enquiry\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Enquiry
 * Enquiry content block
 */
class Enquiry extends Template
{
    /**
     * Set page title on layout prepare
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Tcz Enquiry Module'));
        return parent::_prepareLayout();
    }
}
