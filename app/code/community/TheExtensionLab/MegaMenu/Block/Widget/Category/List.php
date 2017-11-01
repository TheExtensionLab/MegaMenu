<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Category_List
    extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    protected function getCategoryTree()
    {
        $json = $this->getCategoryJson();
        $categoryData = json_decode($json);

        return $categoryData->categories;
    }

    protected function getLoadedMenuNodes()
    {
        $currentMenu = Mage::registry('current_menu');
        $childNodes = $currentMenu->getAllChildNodes();

        return $childNodes;
    }

    protected function _getCategoryNodeById($childNodes, $categoryId)
    {
        $categoryNodeId = 'category-node-'.$categoryId;

        if(!isset($childNodes[$categoryNodeId])):
            return false;
        endif;

        return $childNodes[$categoryNodeId];
    }

    protected function _getCustomCategoryMenuName($categoryNode, $categoryJson)
    {
        if(isset($categoryJson->custom_name)){
            return $categoryJson->custom_name;
        }

        return $categoryNode->getName();
    }
}