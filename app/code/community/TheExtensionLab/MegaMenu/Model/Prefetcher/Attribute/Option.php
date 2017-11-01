<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Prefetcher_Attribute_Option
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues)
    {
        if(isset($directiveValues['option_ids'])){
            $collection = $this->getAttributeOptionCollection($directiveValues['option_ids']);

            if(!isset($directiveValues['attribute_ids']))
            {
                $directiveValues['attribute_ids'] = array();
            }

            $optionIdArray = $this->getOptionIds($collection);
            $directiveValues = $this->storeOptionParentAttributeIds($collection, $directiveValues);

            Mage::register('megamenu_attribute_options', $optionIdArray);
        }
    }

    public function test()
    {

    }

    private function getAttributeOptionCollection(array $optionIds)
    {
        $storeId = Mage::app()->getStore()->getStoreId();

        return Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->addFieldToFilter('main_table.option_id', array('in' => $optionIds))
            ->setStoreFilter($storeId, true);
    }

    private function getOptionIds($collection)
    {
        $optionIdArray = array();
        foreach ($collection as $option) {
            $optionIdArray[$option->getOptionId()] = $option;
        }

        return $optionIdArray;
    }

    private function storeOptionParentAttributeIds($collection, $directiveValues)
    {
        foreach ($collection as $option) {
            if (!in_array($option->getAttributeId(), $directiveValues['attribute_ids'])) {
                $directiveValues['attribute_ids'][] = $option->getAttributeId();
            }
        }

        return $directiveValues;
    }
}