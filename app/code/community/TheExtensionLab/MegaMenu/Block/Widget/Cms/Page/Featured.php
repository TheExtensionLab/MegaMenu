<?php class TheExtensionLab_MegaMenu_Block_Widget_Cms_Page_Featured
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