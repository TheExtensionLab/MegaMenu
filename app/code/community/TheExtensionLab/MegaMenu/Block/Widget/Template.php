<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
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