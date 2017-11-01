<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Template
    extends Mage_Core_Block_Template
{
    protected function getDisplayClass()
    {
        $screensToDisplayOn = $this->getDisplayOn();

        if (empty($screensToDisplayOn)) {
            return '';
        }

        $screensToDisplayOnArray = explode(',', $screensToDisplayOn);

        return $this->_getStylesHelper()->getDisplayClass($screensToDisplayOnArray);
    }

    private function _getStylesHelper()
    {
        return Mage::helper('theextensionlab_megamenu/display_styles');
    }
}