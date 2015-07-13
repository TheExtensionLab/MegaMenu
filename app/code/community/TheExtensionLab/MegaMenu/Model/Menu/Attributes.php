<?php

class TheExtensionLab_MegaMenu_Model_Menu_Attributes
{
    private $_extraAttributes = array();

    public function __construct()
    {
        $this->_getExtraAttributesFromConfig();
    }

    public function addExtraAttributesToSelect($categoryCollection)
    {
        foreach ($this->_extraAttributes as $extraAttribute) {
            $categoryCollection->addAttributeToSelect($extraAttribute);
        }
    }

    public function addExtraFlatAttributesToSelect($select)
    {
        $select->columns($this->_extraAttributes);
    }

    private function _getExtraAttributesFromConfig()
    {
        $extraAttributes = Mage::getConfig()->getNode('global/theextensionlab_megamenu/extra_attributes')->asArray();
        foreach ($extraAttributes as $attributeCode => $value) {
            if (!$this->_isAttributeDisabled($value)) {
                $this->_extraAttributes[] = $attributeCode;
            }
        }
    }

    private function _isAttributeDisabled($value)
    {
        if (isset($value['disabled'])) {
            if ($value['disabled'] == true) {
                return true;
            }
        }

        return false;
    }
}