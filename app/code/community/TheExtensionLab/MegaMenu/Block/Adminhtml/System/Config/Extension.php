<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */
class TheExtensionLab_MegaMenu_Block_Adminhtml_System_Config_Extension
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate(
            'theextensionlab/megamenu/system/config/extension-info.phtml'
        );
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->renderView();
        return $html;
    }
}