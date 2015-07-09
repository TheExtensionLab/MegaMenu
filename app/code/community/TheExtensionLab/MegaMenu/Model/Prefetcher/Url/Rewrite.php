<?php

class TheExtensionLab_MegaMenu_Model_Prefetcher_Url_Rewrite
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues)
    {
        Varien_Profiler::start('megamenu_url_rewrites_prefetching');

        $rewritesCollection = $this->getRewritesCollection($directiveValues['rewrite_ids']);
        $rewriteIdPaths = $this->getRewriteIdPathsFromCollection($rewritesCollection);

        Mage::register('megamenu_url_rewrites', $rewriteIdPaths);
        Varien_Profiler::stop('megamenu_url_rewrites_prefetching');
    }

    private function getRewritesCollection(array $rewriteIds)
    {
        return Mage::getModel('core/url_rewrite')->getCollection()
            ->addFieldToFilter('id_path', array('in' => $rewriteIds));
    }

    private function getRewriteIdPathsFromCollection($collection)
    {
        $rewriteIdPaths = array();

        foreach ($collection as $rewrite) {
            $rewriteIdPaths[$rewrite->getIdPath()] = $rewrite;
        }

        return $rewriteIdPaths;
    }

}