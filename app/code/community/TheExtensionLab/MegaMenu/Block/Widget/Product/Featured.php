<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Product_Featured
    extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    protected function getFeaturedProductsCollection()
    {
        $featuredProducts = json_decode($this->getMegamenuFeaturedProductIds(), true);

        uasort($featuredProducts, array($this, '_featuredProductsSortByPosition'));

        $featuredProductCollection = $this->_createFeaturedProductsCollectionFromPrefetchedData($featuredProducts);

        return $featuredProductCollection;
    }

    private function _createFeaturedProductsCollectionFromPrefetchedData(array $featuredProducts)
    {
        $featuredProductCollection = new Varien_Data_Collection();
        $prefetchedCollection = $this->_getPrefetchedProductCollection();

        foreach ($featuredProducts as $featuredProductId => $featuredProduct) {
            $item = $prefetchedCollection->getItemById($featuredProductId);
            if($item) {
                $featuredProductCollection->addItem($item);
            }
        }

        return $featuredProductCollection;
    }
    private function _getPrefetchedProductCollection()
    {
        return Mage::registry('megamenu_products_collection');
    }

    private static function _featuredProductsSortByPosition($a,$b)
    {
        return $a[0]['position'] - $b[0]['position'];
    }
}