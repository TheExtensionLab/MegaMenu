<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

abstract class TheExtensionLab_MegaMenu_Model_Config_Source_Abstract
    extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
    implements TheExtensionLab_MegaMenu_Model_Config_Source_Interface
{

    protected $_eventPrefix;

    public function getAllOptions()
    {
        $optionsContainer = new Varien_Object();
        $optionsContainer->setOptions($this->getAllOptionsArray());

        Mage::dispatchEvent(
            $this->_eventPrefix . '_get_all_options_array_after',
            array('options_container' => $optionsContainer)
        );

        return $optionsContainer->getOptions();
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function setOptions($options){
        return $this->_options = $options;
    }
}