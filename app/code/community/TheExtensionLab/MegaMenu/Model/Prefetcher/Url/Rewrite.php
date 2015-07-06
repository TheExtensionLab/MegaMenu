<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Url_Rewrite
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$prefetchConfig)
    {
        Varien_Profiler::start('megamenu_url_rewrites_prefetching');
        $rewriteCollectionByIdPath = array();
        $rewritesCollection = Mage::getModel('core/url_rewrite')->getCollection()
            ->addFieldToFilter('id_path', array('in' => $prefetchConfig['rewrite_ids']));

        foreach ($rewritesCollection as $rewrite) {
            $rewriteCollectionByIdPath[$rewrite->getIdPath()] = $rewrite;
        }

        Mage::register('megamenu_url_rewrites', $rewriteCollectionByIdPath);
        Varien_Profiler::stop('megamenu_url_rewrites_prefetching');
    }
}