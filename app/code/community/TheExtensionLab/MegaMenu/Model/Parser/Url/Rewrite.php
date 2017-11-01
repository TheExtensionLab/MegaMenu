<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Parser_Url_Rewrite
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if ($this->_hasValuesRequiredForRewrite()) {
            $this->_getRewriteIdPathsForOptions($params);
        }

        return $prefetchConfig;
    }

    private function _getRewriteIdPathsForOptions($params)
    {
        $optionIds = json_decode($params['option_ids']);
        $categoryId = $params['category_id'];
        foreach ($optionIds as $key => $value):
            $prefetchConfig['rewrite_ids'][] = 'category/' . $categoryId;
        endforeach;

        return $optionIds;
    }

    private function _hasValuesRequiredForRewrite()
    {
        return isset($params['option_ids']) && isset($params['category_id']);
    }
}