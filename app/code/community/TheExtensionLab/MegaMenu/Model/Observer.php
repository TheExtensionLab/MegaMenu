<?php class TheExtensionLab_MegaMenu_Model_Observer
{
    public function pageBlockHtmlTopmenGethtmlBefore(Varien_Event_Observer $observer)
    {
        $menu = $observer->getMenu();
        $block = $observer->getBlock();

        $block->addCacheTag(Mage_Catalog_Model_Category::CACHE_TAG);

        $this->_getMenuPopulator()->addCategoriesToMenu($menu, $block);

        Mage::register('current_menu', $menu);
    }

    public function addCategoryFeildDependancys(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if($block instanceof Mage_Adminhtml_Block_Catalog_Category_Tab_Attributes) {
            $this->_getConfigDependancyModel()->addCategoryFeildDependancys($block);
        }
    }

    public function catalogCategoryFlatLoadnodesBefore(Varien_Event_Observer $observer) {
        $select = $observer->getSelect();
        $this->_getMenuAttributesModel()->addExtraFlatAttributesToSelect($select);
    }

    public function catalogCategoryCollectionLoadBefore(Varien_Event_Observer $observer){
        $categoryCollection = $observer->getEvent()->getCategoryCollection();
        $this->_getMenuAttributesModel()->addExtraAttributesToSelect($categoryCollection);
    }

    /**
     * @return TheExtensionLab_MegaMenu_Model_Config_Dependancy
     */
    private function _getConfigDependancyModel()
    {
        return Mage::getModel('theextensionlab_megamenu/config_dependancy');
    }

    /**
     * @return TheExtensionLab_MegaMenu_Model_Menu_Populator
     */
    private function _getMenuPopulator()
    {

        return Mage::getModel('theextensionlab_megamenu/menu_populator');
    }

    private function _getMenuAttributesModel()
    {
        return Mage::getModel('theextensionlab_megamenu/menu_attributes');
    }
}