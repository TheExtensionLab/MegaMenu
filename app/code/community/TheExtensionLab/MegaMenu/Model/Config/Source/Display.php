<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
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
