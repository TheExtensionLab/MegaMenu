<?php

class TheExtensionLab_MegaMenu_Model_Product_Prefetcher
    implements TheExtensionLab_MegaMenu_Model_Widget_Prefetcher_Interface
{

    public function prefetchWaitingData(&$waitingData)
    {
        if (isset($waitingData['product_ids'])) {
            $featuredProductLimit = 20;

            $featuredProductsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $waitingData['product_ids']))
                ->addAttributeToSelect(array('name', 'menu_image', 'price', 'special_price', 'url_key'))
                ->setPageSize($featuredProductLimit)
                ->load();

            Mage::register('megamenu_products_collection', $featuredProductsCollection);
        }
    }

}