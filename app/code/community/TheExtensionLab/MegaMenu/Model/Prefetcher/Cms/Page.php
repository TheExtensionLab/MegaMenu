<?php class TheExtensionLab_MegaMenu_Model_Prefetcher_Cms_Page implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues)
    {
        if(isset($directiveValues['cms_page_ids']))
        {
            $pageCollection = Mage::getModel('cms/page')->getCollection()
                ->addFieldToFilter('page_id', array('in' => $directiveValues['cms_page_ids']))
                ->load();

            Mage::register('megamenu_cms_pages', $pageCollection);
        }
    }
}