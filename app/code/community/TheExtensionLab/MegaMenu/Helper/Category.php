<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Helper_Category extends Mage_Core_Model_Abstract
{
    protected $_storeCategories = array();

    public function getMenuName($category)
    {
        if($category->getMenuName()){
            return $category->getMenuName();
        }

        return $category->getName();
    }

    public function getFullImageUrl($image)
    {
        $url = false;
        if ($image) {
            $url = Mage::getBaseUrl('media').'catalog' . DS . 'category' . DS .$image;
        }
        return $url;
    }

    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        $parent = Mage::app()->getStore()->getRootCategoryId();

        $cacheKey = $this->_makeCacheKey(
            $parent, $sorted, $asCollection, $toLoad
        );

        if (isset($this->_storeCategories[$cacheKey])) {
            return $this->_storeCategories[$cacheKey];
        }

        $recursionLevel = $this->_getRecursionLevel();
        $storeCategories = $this->_getCategories($parent, $recursionLevel, $sorted, $asCollection, $toLoad);



        $this->_storeCategories[$cacheKey] = $storeCategories;
        return $storeCategories;
    }

    private function _makeCacheKey($parent, $sorted, $asCollection, $toLoad)
    {
        return sprintf('%d-%d-%d-%d', $parent, $sorted, $asCollection, $toLoad);
    }

    private function _checkIfParentNodeStillExists($parent)
    {
        /* @var Mage_Catalog_Model_Category */
        $category = Mage::getModel('catalog/category');
        return $category->checkId($parent);
    }

    private function _getRecursionLevel()
    {
        $recursionLevel = (int)Mage::app()->getStore()->getConfig(
            'catalog/navigation/max_depth'
        );

        if ($recursionLevel < 0) {
            $recursionLevel = 0;
        }

        return $recursionLevel;

    }

    private function _getCategories(
        $parent, $recursionLevel = 0, $sorted = false, $asCollection = false, $toLoad = true, $onlyActive = false
    ) {
        if(Mage::helper('catalog/category_flat')->isEnabled() && Mage::helper('catalog/category_flat')->isBuilt()) {
            return $this->_getCategoriesFromFlatTables($parent, $recursionLevel, $sorted, $asCollection, $toLoad);
        }
        /* @var $tree Mage_Catalog_Model_Resource_Category_Tree */
        $tree = Mage::getResourceModel('catalog/category_tree');

        $collection = $tree->getCollection($sorted);
        $collection->addAttributeToFilter('include_in_menu', 1);

        $nodes = $tree->loadNode($parent)
            ->loadChildren($recursionLevel)
            ->getChildren();

        $tree->addCollectionData($collection, $sorted, $parent, $toLoad, $onlyActive);

        if ($asCollection) {
            return $tree->getCollection();
        }

        return $nodes;
    }

    private function _getCategoriesFromFlatTables($parent, $recursionLevel = 0, $sorted = false, $asCollection = false, $toLoad = true){
        return Mage::getResourceModel('theextensionlab_megamenu/category_flat')->getCategories($parent, $recursionLevel, $sorted, $asCollection, $toLoad);
    }
}