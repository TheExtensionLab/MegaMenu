<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Prefetcher_Url_Rewrite
    implements TheExtensionLab_MegaMenu_Model_Prefetcher_Interface
{
    public function prefetchData(&$directiveValues)
    {
        Varien_Profiler::start('megamenu_url_rewrites_prefetching');

        if(isset($directiveValues['rewrite_ids'])){
            $rewritesCollection = $this->getRewritesCollection($directiveValues['rewrite_ids']);
            $rewriteIdPaths = $this->getRewriteIdPathsFromCollection($rewritesCollection);

            Mage::register('megamenu_url_rewrites', $rewriteIdPaths);
        }

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