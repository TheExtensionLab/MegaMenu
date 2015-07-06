<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Attribute_Option
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchWaitingData(&$waitingData)
    {
        $optionIdArray = array();
        $storeId = Mage::app()->getStore()->getStoreId();

        $collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->addFieldToFilter('main_table.option_id', array('in' => $waitingData['option_ids']))
            ->setStoreFilter($storeId, true);

        if(!isset($waitingData['attribute_ids']))
        {
            $waitingData['attribute_ids'] = array();
        }

        foreach ($collection as $option) {
            $optionIdArray[$option->getOptionId()] = $option;

            if (!in_array($option->getAttributeId(), $waitingData['attribute_ids'])) {
                $waitingData['attribute_ids'][] = $option->getAttributeId();
            }
        }

        Mage::register('megamenu_attribute_options', $optionIdArray);
    }
}