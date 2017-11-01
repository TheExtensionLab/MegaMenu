<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Cms_Block extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    public function getBlock()
    {
        $blockId = $this->getMenuStaticBlockId();

        if (!$blockId) {
            return false;
        }

        $collection = Mage::registry('megamenu_cms_blocks');
        $block = $collection->getItemById($blockId);
        return $block;
    }
}