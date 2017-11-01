<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Cms_Page_Featured
    extends TheExtensionLab_MegaMenu_Block_Widget_Template implements Mage_Widget_Block_Interface
{
    public function getCmsPage()
    {
        $collection = Mage::registry('megamenu_cms_pages');
        $cmsPage = $collection->getItemById($this->getMenuFeaturedCmsId());
        return $cmsPage;
    }

    public function getCmsPageUrl(Mage_Cms_Model_Page $cmsPage)
    {
        return $this->getUrl($cmsPage->getIdentifier());
    }
}