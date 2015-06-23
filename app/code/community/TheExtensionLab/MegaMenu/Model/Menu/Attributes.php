<?php class TheExtensionLab_MegaMenu_Model_Menu_Attributes extends Mage_Core_Model_Abstract
{
    protected $_extraAttributes = array();

    public function __construct()
    {
        $this->_getExtraAttributesFromConfiguration();
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

    private function _getExtraAttributesFromConfiguration()
    {
        $extraAttributes = Mage::getConfig()->getNode('global/theextensionlab_megamenu/extra_attributes')->asArray();
        foreach ($extraAttributes as $attributeCode => $value) {
            if ($value != 'disabled') {
                $this->_extraAttributes[] = $attributeCode;
            }
        }
    }

}