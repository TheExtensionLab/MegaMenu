<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Model_Prefetcher_Cms_Page extends EcomDev_PHPUnit_Test_Case
{
    private $_prefetcher;
    public function setUp()
    {
        $this->_prefetcher = new TheExtensionLab_MegaMenu_Model_Prefetcher_Cms_Page;
    }

    public function testImplementsPrefetcherInterface()
    {
        $class = new ReflectionClass('TheExtensionLab_MegaMenu_Model_Prefetcher_Cms_Page');
        $this->assertTrue($class->implementsInterface('TheExtensionLab_MegaMenu_Model_Prefetcher_Interface'));
    }

    public function testNoCmsIdsSetsNoCollection()
    {
        $directiveValues = array();
        $this->_prefetcher->prefetchData($directiveValues);
        $cmsRegistryCollection = Mage::registry('megamenu_cms_pages');
        $this->assertEmpty($cmsRegistryCollection);
    }

    public function testCollectionRegisteredWhenCmsIdSet()
    {
        $directiveValues = array();
        $directiveValues['cms_page_ids'] = array(1);
        $this->_prefetcher->prefetchData($directiveValues);
        $cmsRegistryCollection = Mage::registry('megamenu_cms_pages');
        $this->assertTrue($cmsRegistryCollection instanceof Mage_Cms_Model_Resource_Page_Collection);
    }
}