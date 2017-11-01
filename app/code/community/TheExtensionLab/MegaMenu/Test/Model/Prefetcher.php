<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Model_Prefetcher extends EcomDev_PHPUnit_Test_Case
{
    private $_prefetcher;

    public function setUp()
    {
        $this->_prefetcher = new TheExtensionLab_MegaMenu_Model_Prefetcher();
    }

    public function testCanGetPrefetchMethod()
    {
        $this->assertTrue(method_exists($this->_prefetcher, 'prefetch'));
    }

    public function testPrefetchersPassedInCorrectly()
    {
        $class = new ReflectionClass("TheExtensionLab_MegaMenu_Model_Prefetcher");
        $property = $class->getProperty("_prefetchModels");
        $property->setAccessible(true);

        $prefetchModels = $property->getValue($this->_prefetcher);

        $this->assertArrayHasKey('product', $prefetchModels);
    }

    public function testHasParser()
    {
        $class = new ReflectionClass("TheExtensionLab_MegaMenu_Model_Prefetcher");
        $property = $class->getProperty("_parser");
        $property->setAccessible(true);

        $parser = $property->getValue($this->_prefetcher);

        $this->assertNotEmpty($parser);
    }

    public function testChildModelUpdatesEventIsDispatched()
    {
        $this->assertEventDispatched('megamenu_prepare_prefetch_models_after');
    }

    public function testChildPrefetchDataMethodsCalled()
    {
        $defaultPrefetchersArray = array(
            'url_rewrite' => 'theextensionlab_megamenu/prefetcher_url_rewrite'
        );

        $this->_prefetcher = new TheExtensionLab_MegaMenu_Model_Prefetcher($defaultPrefetchersArray);

        $mock = $this->getModelMock('theextensionlab_megamenu/prefetcher_url_rewrite',array('prefetchData'));
        $mock
            ->expects($this->once())
            ->method('prefetchData');
        $this->replaceByMock('model', 'theextensionlab_megamenu/prefetcher_url_rewrite',$mock);

        $this->_prefetcher->prefetch('Some Content');
    }

}