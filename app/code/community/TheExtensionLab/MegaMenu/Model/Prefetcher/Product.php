<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Prefetcher_Product
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{

    public function prefetchData(&$directiveValues)
    {
        if ($this->_hasProductsToLoad($directiveValues)) {
            $featuredProductLimit = 20;

            $featuredProductsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $directiveValues['product_ids']))
                ->addAttributeToSelect(array('name', 'menu_image', 'price', 'special_price', 'url_key'))
                ->setPageSize($featuredProductLimit)
                ->load();

            Mage::register('megamenu_products_collection', $featuredProductsCollection);
        }
    }

    protected function _hasProductsToLoad($directiveValues)
    {
        return isset($directiveValues['product_ids']);
    }

}