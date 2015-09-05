<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
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

        if (!$this->_checkIfParentNodeStillExists($parent)) {
            if ($asCollection) {
                return new Varien_Data_Collection();
            }
            return array();
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
        /* @var $tree Mage_Catalog_Model_Resource_Category_Tree */
        $tree = Mage::getResourceModel('catalog/category_tree');

        $nodes = $tree->loadNode($parent)
            ->loadChildren($recursionLevel)
            ->getChildren();

        $tree->addCollectionData(null, $sorted, $parent, $toLoad, $onlyActive);

        if ($asCollection) {
            return $tree->getCollection();
        }

        return $nodes;
    }


}