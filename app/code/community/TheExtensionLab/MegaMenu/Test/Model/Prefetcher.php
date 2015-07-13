<?php class TheExtensionLab_MegaMenu_Test_Model_Prefetcher extends EcomDev_PHPUnit_Test_Case
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

    public function testChildPrefetchDataMethodsCalledAndPassedAnArray()
    {
        $defaultPrefetchersArray = array(
            'url_rewrite' => 'theextensionlab_megamenu/prefetcher_url_rewrite'
        );

        $this->_prefetcher = new TheExtensionLab_MegaMenu_Model_Prefetcher($defaultPrefetchersArray);

        $spy = new TheExtensionLab_MegaMenu_Test_Model_Prefetcher_Url_Rewrite_Stub;
        $this->app()->getConfig()->replaceInstanceCreation(
            'model', 'theextensionlab_megamenu/prefetcher_url_rewrite', $spy
        );

        $this->_prefetcher->prefetch('Some Content');

        $this->assertEquals(1, $spy->getQtyCalled());
        $this->assertTrue(is_array($spy->getValuePassed()));
    }

}