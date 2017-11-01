<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Parser_Product_Featured
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if ($this->_hasValuesRequiredForFeaturedProducts($params)) {
            $prefetchConfig['product_ids'] = array_keys($this->_getFeaturedProductIdsAsArray($params));
        }

        return $prefetchConfig;
    }

    private function _getFeaturedProductIdsAsArray($params)
    {
        $featuredProductIdsJsonString = $params['megamenu_featured_product_ids'];
        $featuredProductData = json_decode($featuredProductIdsJsonString, 1);
        return $featuredProductData;
    }

    private function _hasValuesRequiredForFeaturedProducts($params)
    {
        return isset($params['megamenu_featured_product_ids']);
    }
}