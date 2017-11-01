<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Category_Featured
    extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    protected function getFeaturedCategoryNode()
    {

        $currentMenu = Mage::registry('current_menu');
        $childNodes = $currentMenu->getAllChildNodes();

        $categoryNodeId = 'category-node-'.$this->getMenuFeaturedCategoryId();

        if(!isset($childNodes[$categoryNodeId])){
            return false;
        }

        $categoryNode = $childNodes[$categoryNodeId];

        return $categoryNode;

    }
}