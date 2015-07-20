<?php class TheExtensionLab_MegaMenu_Block_Adminhtml_Cms_Page_Edit_Tab_Menu extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return $this->_getNameOfTab();
    }

    public function getTabTitle()
    {
        return $this->_getNameOfTab();
    }

    private function _getNameOfTab()
    {
        return Mage::helper('theextensionlab_megamenu')->__('MegaMenu Settings');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}