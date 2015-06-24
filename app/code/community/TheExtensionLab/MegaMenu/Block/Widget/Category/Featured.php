<?php class TheExtensionLab_MegaMenu_Block_Widget_Category_Featured
    extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    protected function getFeaturedCategoryNode()
    {

        $currentMenu = Mage::registry('current_menu');
        $childNodes = $currentMenu->getAllChildNodes();

        $categoryNodeId = 'category-node-'.$this->getMenuFeaturedCategoryId();
        $categoryNode = $childNodes[$categoryNodeId];

        return $categoryNode;

    }
}