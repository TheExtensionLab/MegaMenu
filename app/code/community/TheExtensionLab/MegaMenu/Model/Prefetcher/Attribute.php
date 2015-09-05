<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Prefetcher_Attribute
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues)
    {
        if(isset($directiveValues['attribute_ids'])) {
            $collection = $this->getAttributeCollection($directiveValues['attribute_ids']);
            $attributeIdArray = $this->getAttributeIdsArrayFromCollection($collection);

            Mage::register('megamenu_attributes', $attributeIdArray);
        }
    }

    private function getAttributeIdsArrayFromCollection($collection)
    {
        $attributeIdArray = array();

        foreach ($collection as $attribute) {
            $attributeIdArray[$attribute->getAttributeId()] = $attribute;
        }

        return $attributeIdArray;
    }

    private function getAttributeCollection(array $attributeIds)
    {
        return  Mage::getResourceModel('catalog/product_attribute_collection')
            ->addFieldToFilter('main_table.attribute_id', array('in' => $attributeIds))
            ->addVisibleFilter();
    }
}