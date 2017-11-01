<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Config_Source_Link_Type
    extends TheExtensionLab_MegaMenu_Model_Config_Source_Abstract
{

    protected $_eventPrefix = 'link_type';

    const DEFAULT_LINK_TYPE = 0;
    const INTERNAL_LINK_TYPE = 1;
    const EXTERNAL_LINK_TYPE = 2;
    const NO_LINK = 3;

    public function getAllOptionsArray()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => $this->_getHelper()->__('Default'),
                    'value' => self::DEFAULT_LINK_TYPE
                ),
                array(
                    'label' => $this->_getHelper()->__('Internal Link'),
                    'value' => self::INTERNAL_LINK_TYPE
                ),
                array(
                    'label' => $this->_getHelper()->__('External Link'),
                    'value' => self::EXTERNAL_LINK_TYPE
                ),
                array(
                    'label' => $this->_getHelper()->__('No Link'),
                    'value' => self::NO_LINK
                )
            );
        }
        return $this->_options;
    }

    private function _getHelper()
    {
        return Mage::helper('theextensionlab_megamenu');
    }
}