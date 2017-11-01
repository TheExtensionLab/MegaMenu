<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Config_Source_Display
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'small', 'label'=>Mage::helper('adminhtml')->__('Small (Mobile)')),
            array('value' => 'medium', 'label'=>Mage::helper('adminhtml')->__('Medium (Tablet)')),
            array('value' => 'large', 'label'=>Mage::helper('adminhtml')->__('Large (Desktop)'))
        );
    }

}
