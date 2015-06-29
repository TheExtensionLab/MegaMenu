<?php class TheExtensionLab_MegaMenu_Block_Widget_Category_List
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
}