<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Product
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{

    public function prefetchData(&$prefetchConfig)
    {
        if (isset($prefetchConfig['product_ids'])) {
            $featuredProductLimit = 20;

            $featuredProductsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $prefetchConfig['product_ids']))
                ->addAttributeToSelect(array('name', 'menu_image', 'price', 'special_price', 'url_key'))
                ->setPageSize($featuredProductLimit)
                ->load();

            Mage::register('megamenu_products_collection', $featuredProductsCollection);
        }
    }

}