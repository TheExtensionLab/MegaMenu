<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Parser_Attribute_Option
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if($this->_hasValuesRequiredForAttributeOptions($params)) {

            $optionIds = json_decode($params['option_ids'],1);
            $prefetchConfig['option_ids'] = array_keys($optionIds);

            if($this->_hasCategoryIdRequiredForRewritePath($params)) {
                $prefetchConfig['rewrite_ids'][] = 'category/' . $params['category_id'];
            }
        }

        return $prefetchConfig;
    }

    private function _hasCategoryIdRequiredForRewritePath($params)
    {
        return isset($params['category_id']);
    }

    private function _hasValuesRequiredForAttributeOptions($params)
    {
        return isset($params['option_ids']);
    }
}