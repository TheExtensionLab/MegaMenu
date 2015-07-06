<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Attribute_Option
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$prefetchConfig)
    {
        $optionIdArray = array();
        $storeId = Mage::app()->getStore()->getStoreId();

        $collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->addFieldToFilter('main_table.option_id', array('in' => $prefetchConfig['option_ids']))
            ->setStoreFilter($storeId, true);

        if(!isset($prefetchConfig['attribute_ids']))
        {
            $prefetchConfig['attribute_ids'] = array();
        }

        foreach ($collection as $option) {
            $optionIdArray[$option->getOptionId()] = $option;

            if (!in_array($option->getAttributeId(), $prefetchConfig['attribute_ids'])) {
                $prefetchConfig['attribute_ids'][] = $option->getAttributeId();
            }
        }

        Mage::register('megamenu_attribute_options', $optionIdArray);
    }
}