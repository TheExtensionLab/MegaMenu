<?php class TheExtensionLab_MegaMenu_Helper_Attribute_Url
{
    public function getFilterUrl($categoryId, $code, $value)
    {
        $requestPath = '';
        $query = array(
            $code                                                        => $value,
            Mage::getBlockSingleton('page/html_pager')->getPageVarName() => null,
        );

        $urlRewritesCollection = Mage::registry('megamenu_url_rewrites');

        if (isset($urlRewritesCollection['category/' . $categoryId])) {
            $requestPath = $urlRewritesCollection['category/' . $categoryId]->getRequestPath();
        }

        $url = Mage::getUrl($requestPath, array('_query' => $query));
        $url = str_replace('/?', '?', $url);

        $urlData = new Varien_Object(
            array('category_id' => $categoryId,
                  'attribute_code' => $code,
                  'value' => $value,
                  'query' => $query,
                  'url'         => $url
            )
        );

        //If you have a custom layered nav extension you may need to use this to correct to url
        //to be consistant with other places on your website.
        Mage::dispatchEvent(
            'megamenu_getfilterurl_after', array('url_data' => $urlData)
        );

        return $urlData->getUrl();
    }
}