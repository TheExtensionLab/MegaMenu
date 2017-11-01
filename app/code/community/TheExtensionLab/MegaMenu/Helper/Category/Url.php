<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Helper_Category_Url extends Mage_Core_Model_Abstract
{
    public function getCategoryUrl($category)
    {
        if ($this->_checkIsCategoryInternalLink($category)) {
            $url = Mage::getUrl($category->getMenuLink());
            $url = Mage::getModel('core/url')->sessionUrlVar($url);
            return $url;
        }

        if ($this->_checkIsCategoryExternalLink($category)) {
            return $category->getMenuLink();
        }

        return $this->_getCategoryHelper()->getCategoryUrl($category);
    }

    private function _checkIsCategoryInternalLink($category)
    {
        $internalLinkType = TheExtensionLab_MegaMenu_Model_Config_Source_Link_Type::INTERNAL_LINK_TYPE;
        $isCategoryInternalLink = ($category->getMenuLinkType() == $internalLinkType);
        return $isCategoryInternalLink;
    }

    private function _checkIsCategoryExternalLink($category)
    {
        $externalLinkType = TheExtensionLab_MegaMenu_Model_Config_Source_Link_Type::EXTERNAL_LINK_TYPE;
        $isCategoryExternalLink = ($category->getMenuLinkType() == $externalLinkType);
        return $isCategoryExternalLink;
    }

    private function _getCategoryHelper()
    {
        return Mage::helper('catalog/category');
    }
}