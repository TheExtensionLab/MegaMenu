<?php

class TheExtensionLab_MegaMenu_Model_Url_Rewrite_Prefetcher
    implements TheExtensionLab_MegaMenu_Model_Widget_Prefetcher_Interface
{
    public function prefetchWaitingData(&$waitingData)
    {
        Varien_Profiler::start('megamenu_url_rewrites_prefetching');
        $rewriteCollectionByIdPath = array();
        $rewritesCollection = Mage::getModel('core/url_rewrite')->getCollection()
            ->addFieldToFilter('id_path', array('in' => $waitingData['rewrite_ids']));


        foreach ($rewritesCollection as $rewrite) {
            $rewriteCollectionByIdPath[$rewrite->getIdPath()] = $rewrite;
        }

        Mage::register('megamenu_url_rewrites', $rewriteCollectionByIdPath);
        Varien_Profiler::stop('megamenu_url_rewrites_prefetching');
    }
}