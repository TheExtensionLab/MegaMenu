<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */
class TheExtensionLab_MegaMenu_Model_Prefetcher
{
    private $_prefetchModels = array();
    private $_parser = array();
    private $_directiveValues = array();

    public function __construct()
    {
        $this->_prepareChildModels();
    }

    public function prefetch($value)
    {
        $this->_getDirectiveValues($value);
        $this->_prefetchWaitingData();
    }

    public function setChildPrefetcher($key,$modelAlias){
        $this->_prefetchModels[$key] = $modelAlias;
    }

    private function _prepareChildModels()
    {
        $this->_prefetchModels = $this->_getDefaultPrefetchers();
        $this->_parser = Mage::getModel('theextensionlab_megamenu/parser', $this->_getDefaultParsers());
        $this->_dispatchEventToAllowPrefetchAndParserModelUpdates();
    }

    private function _dispatchEventToAllowPrefetchAndParserModelUpdates()
    {
        Mage::dispatchEvent(
            'megamenu_prepare_prefetch_models_after', array('prefetcher' => $this, 'parser' => $this->_parser)
        );
    }

    private function _getDefaultPrefetchers()
    {
        return array(
            'product'          => 'theextensionlab_megamenu/prefetcher_product',
            'attribute_option' => 'theextensionlab_megamenu/prefetcher_attribute_option',
            'attribute'        => 'theextensionlab_megamenu/prefetcher_attribute',
            'url_rewrite'      => 'theextensionlab_megamenu/prefetcher_url_rewrite',
            'cms_page'         => 'theextensionlab_megamenu/prefetcher_cms_page',
            'cms_block'        => 'theextensionlab_megamenu/prefetcher_cms_block'
        );
    }

    private function _getDefaultParsers()
    {
        return array(
            'featured_product'  => 'theextensionlab_megamenu/parser_product_featured',
            'attribute_option'  => 'theextensionlab_megamenu/parser_attribute_option',
            'url_rewrite'       => 'theextensionlab_megamenu/parser_url_rewrite',
            'featured_cms_page' => 'theextensionlab_megamenu/parser_cms_page_featured',
            'cms_block'         => 'theextensionlab_megamenu/parser_cms_block'
        );
    }

    private function _getDirectiveValues($value)
    {
        $this->_directiveValues = $this->_parser->getDirectiveValues($value);
    }


    private function _prefetchWaitingData()
    {
        Varien_Profiler::start('megamenu_prefetch_and_store_data');

        foreach ($this->_prefetchModels as $modelAlias) {
            $model = Mage::getModel($modelAlias);
            if (is_callable(array($model, 'prefetchData'))) {
                $model->prefetchData($this->_directiveValues);
            }
        }

        Varien_Profiler::stop('megamenu_prefetch_and_store_data');
    }

}