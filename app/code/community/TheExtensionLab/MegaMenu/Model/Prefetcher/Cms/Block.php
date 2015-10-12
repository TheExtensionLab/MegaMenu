<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
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

            Mage::register('megamenu_cms_blocks', $blockCollection);
        }
    }
}