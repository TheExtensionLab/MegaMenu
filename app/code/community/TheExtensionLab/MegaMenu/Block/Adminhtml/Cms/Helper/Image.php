<?php class TheExtensionLab_MegaMenu_Block_Adminhtml_Cms_Helper_Image extends Varien_Data_Form_Element_Image
{
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::getBaseUrl('media').'cms'. DS .'menu' . DS . $this->getValue();
        }
        return $url;
    }
}