<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Prefetcher_Cms_Block implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues){
        if(isset($directiveValues['static_block_ids']))
        {
            $blockCollection = Mage::getModel('cms/block')->getCollection()
                ->addFieldToFilter('block_id', array('in' => $directiveValues['static_block_ids']))
                ->load();

            $this->_filterBlockCollectionContent($blockCollection);

            Mage::register('megamenu_cms_blocks', $blockCollection);
        }
    }

    private function _filterBlockCollectionContent($blockCollection)
    {
        foreach ($blockCollection as $block) {
            $helper = Mage::helper('cms');
            $processor = $helper->getBlockTemplateProcessor();
            $block->setContent($processor->filter($block->getContent()));
        }
    }
}