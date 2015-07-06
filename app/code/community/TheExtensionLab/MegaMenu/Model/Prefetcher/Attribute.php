<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Attribute
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchWaitingData(&$waitingData)
    {
        $attributeIdArray = array();
        $collection = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter('main_table.attribute_id', array('in' => $waitingData['attribute_ids']))
            ->addVisibleFilter();

        foreach ($collection as $attribute) {
            $attributeIdArray[$attribute->getAttributeId()] = $attribute;
        }

        Mage::register('megamenu_attributes', $attributeIdArray);
    }
}