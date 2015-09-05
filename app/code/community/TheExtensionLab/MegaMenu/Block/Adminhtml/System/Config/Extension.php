<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
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

    public function checkExtension()
    {
        return Mage::helper('theextensionlab_megamenu/protector')->checkExtension();
    }

    public function getErrorMessage()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        return $this->__(
            'The Serial Key for TheExtensionLab_MegaMenu is invalid or not present and therefore the functionality of this extension has been limited. (ServerName : %s)',$serverName
        );
    }
}