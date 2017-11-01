<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Helper_Attribute_Url
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
        $url = Mage::getModel('core/url')->sessionUrlVar($url);
        $url = str_replace('/?', '?', $url);

        $urlData = new Varien_Object(
            array('category_id' => $categoryId,
                  'attribute_code' => $code,
                  'value' => $value,
                  'query' => $query,
                  'url'         => $url
            )
        );

        $this->_dispatchEventToAllowUrlCustomisation($urlData);

        return $urlData->getUrl();
    }

    private function _dispatchEventToAllowUrlCustomisation($urlData)
    {
        Mage::dispatchEvent(
            'megamenu_getfilterurl_after', array('url_data' => $urlData)
        );
    }
}