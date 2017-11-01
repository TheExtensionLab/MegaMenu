<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Config_Source_Dropdown_Type
    extends TheExtensionLab_MegaMenu_Model_Config_Source_Abstract
{

    protected $_eventPrefix = 'dropdown_type';

    const ABSOLUTE_CENTER = 1;
    const ABSOLUTE_LEFT = 2;
    const ABSOLUTE_RIGHT = 3;
    const RELATIVE_CENTER = 4;
    const HANG_RIGHT = 5;
    const HANG_LEFT = 6;

    public function getAllOptionsArray()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => $this->_getHelper()->__('Absolute Center (Fullwidth)'),
                    'value' => self::ABSOLUTE_CENTER
                ),
                array(
                    'label' => $this->_getHelper()->__('Absolute Left'),
                    'value' => self::ABSOLUTE_LEFT
                ),
                array(
                    'label' => $this->_getHelper()->__('Absolute Right'),
                    'value' => self::ABSOLUTE_RIGHT
                ),
                array(
                    'label' => $this->_getHelper()->__('Relative Center'),
                    'value' => self::RELATIVE_CENTER
                ),
                array(
                    'label' => $this->_getHelper()->__('Hang Right'),
                    'value' => self::HANG_RIGHT
                ),
                array(
                    'label' => $this->_getHelper()->__('Hang Left'),
                    'value' => self::HANG_LEFT
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