<?php
class TheExtensionLab_MegaMenu_Model_Parser_Product_Featured
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function saveDataToPrefetch($params)
    {
        $dataToPrefetch = array();

        if(isset($params['megamenu_featured_product_ids']))
        {
            $featuredProductIds = $params['megamenu_featured_product_ids'];

            $featuredProductsJson = json_decode($featuredProductIds);

            foreach($featuredProductsJson as $featuredProductId => $featuredProductPosition)
            {
                $dataToPrefetch['product_ids'][] = $featuredProductId;
            }
        }

        return $dataToPrefetch;
    }
}