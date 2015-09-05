<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Prefetcher_Cms_Page implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
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