<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.lab/license/license.txt - Commercial License
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

        if($columns > 1) {
            $class = "content-columns-{$columns}";
        }

        return $class;
    }

    protected function getDisplayClass()
    {
        $displayClass = parent::getDisplayClass();
        if($this->hasContentColumns()){
            $displayClass.= ' content-columns-section';
        }

        return $displayClass;
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