<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Parser_Cms_Block
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if ($this->_hasValidBlockId($params)){
            $prefetchConfig['static_block_ids'][] = $params['menu_static_block_id'];
        }
        return $prefetchConfig;
    }

    private function _hasValidBlockId($params)
    {
        if (!isset($params['menu_static_block_id'])) {
            return false;
        }

        return is_numeric($params['menu_static_block_id']);
    }
}