<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Attribute_List
    extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    protected function getClass()
    {
        $class = '';
        $columns = $this->getListColumns();

        if ($columns > 1) {
            $class = "content-columns-{$columns}";
        }

        return $class;
    }

    protected function getDisplayClass()
    {
        $displayClass = parent::getDisplayClass();
        if ($this->hasContentColumns()) {
            $displayClass .= ' content-columns-section';
        }

        return $displayClass;
    }

    public function getOptionIds(){
        $optionsIds = json_decode($this->getData('option_ids'),true);
        uasort($optionsIds, array($this, '_sortOptionsByPosition'));
        return $optionsIds;
    }

    private static function _sortOptionsByPosition($a,$b)
    {
        return $a[0]['position'] - $b[0]['position'];
    }

    private function hasContentColumns()
    {
        $columns = $this->getListColumns();

        if($columns > 1) {
            return true;
        }

        return false;
    }
}