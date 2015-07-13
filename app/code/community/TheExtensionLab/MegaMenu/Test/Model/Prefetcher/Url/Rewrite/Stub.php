<?php

class TheExtensionLab_MegaMenu_Test_Model_Prefetcher_Url_Rewrite_Stub
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    private $_qtyCalled = 0;
    private $_valuePassed = null;

    public function prefetchData(&$directiveValues)
    {
        $this->_qtyCalled++;
        $this->_valuePassed = $directiveValues;
        return true;
    }

    public function getQtyCalled()
    {
        return $this->_qtyCalled;
    }

    public function getValuePassed()
    {
        return $this->_valuePassed;
    }
}