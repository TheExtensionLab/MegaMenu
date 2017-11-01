<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Observer
{
    private $_menuKey = 'current_menu';

    public function pageBlockHtmlTopmenuGetHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        $block->addCacheTag(Mage_Catalog_Model_Category::CACHE_TAG);

        $menu = $observer->getMenu();

        if(!$this->_isMenuTreeAlreadyStored()){
            $this->_getMenuPopulator()->addCategoriesToMenu($menu, $block);
            Mage::register($this->_menuKey, $menu);
        }
    }

    public function enableWysiwygInWysiwygConfig(Varien_Event_Observer $observer)
    {
        $wysiwygConfig = $observer->getEvent()->getConfig();
        $wysiwygConfig->setAddWidgets('true');
    }

    public function catalogCategoryFlatLoadnodesBefore(Varien_Event_Observer $observer) {
        $select = $observer->getSelect();
        $this->_getMenuAttributesModel()->addExtraFlatAttributesToSelect($select);
    }

    public function catalogCategoryCollectionLoadBefore(Varien_Event_Observer $observer){
        $categoryCollection = $observer->getEvent()->getCategoryCollection();
        $this->_getMenuAttributesModel()->addExtraAttributesToSelect($categoryCollection);
    }

    public function cmsPagePrepareSave(Varien_Event_Observer $observer)
    {
        $pageModel = $observer->getPage();

        try {
            $path = Mage::getBaseDir('media') . DS . 'cms' . DS . 'menu' . DS;
            if (isset($_FILES['menu_image'])) {
                $uploader = new Mage_Core_Model_File_Uploader('menu_image');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(true);
                $result = $uploader->save($path);

                $pageModel->setMenuImage($result['file']);
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }

    public function adminhtmlBlockHtmlBefore(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if($block instanceof Mage_Adminhtml_Block_Catalog_Category_Tab_Attributes) {
            $this->_getConfigDependancyModel()->addCategoryFieldDependancys($block);
        }

        if($block instanceof Mage_Adminhtml_Block_Cms_Page_Edit_Form)
        {
            $form = $block->getForm();
            $form->setEnctype('multipart/form-data');
        }
    }

    private function _isMenuTreeAlreadyStored(){
        if(Mage::registry($this->_menuKey) == null){
            return false;
        }

        return true;
    }

    private function _getConfigDependancyModel()
    {
        return Mage::getModel('theextensionlab_megamenu/config_dependancy');
    }

    private function _getMenuPopulator()
    {
        return Mage::getModel('theextensionlab_megamenu/menu_populator');
    }

    private function _getMenuAttributesModel()
    {
        return Mage::getModel('theextensionlab_megamenu/menu_attributes');
    }

    private function _getConfigUpdater()
    {
        return Mage::getModel('theextensionlab_megamenu/config_updater');
    }

    private function _getProtectorHelper()
    {
        return Mage::helper('theextensionlab_megamenu/protector');
    }
}