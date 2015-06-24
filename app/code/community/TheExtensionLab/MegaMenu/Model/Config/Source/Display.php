<?php class TheExtensionLab_MegaMenu_Model_Config_Source_Display
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'small', 'label'=>Mage::helper('adminhtml')->__('Small (Mobile)')),
            array('value' => 'medium', 'label'=>Mage::helper('adminhtml')->__('Medium (Tablet)')),
            array('value' => 'large', 'label'=>Mage::helper('adminhtml')->__('Large (Desktop)'))
        );
    }

}
