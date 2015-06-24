<?php class TheExtensionLab_MegaMenu_Block_Widget_Template
    extends Mage_Core_Block_Template
{
    public function getDisplayClass()
    {
        $screensToDisplayOn = $this->getDisplayOn();

        if(empty($screensToDisplayOn)){
            return '';
        }

        $screensToDisplayOnArray = explode(',',$screensToDisplayOn);

        return $this->_getStylesHelper()->getDisplayClass($screensToDisplayOnArray);
    }

    private function _getStylesHelper()
    {
        return Mage::helper('theextensionlab_megamenu/display_styles');
    }
}