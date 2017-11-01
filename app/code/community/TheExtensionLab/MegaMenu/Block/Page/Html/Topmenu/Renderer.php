<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Page_Html_Topmenu_Renderer
    extends Mage_Page_Block_Html_Topmenu_Renderer
{

    protected function _toHtml()
    {
        $html = parent::_toHtml();
        $prefetcher = $this->_getMegaMenuHelper()->getMenuWidgetPrefetcher();
        $prefetcher->prefetch($html);
        $processor = $this->_getMegaMenuHelper()->getMenuTemplateProcessor();
        $html = $processor->filter($html);
        return $html;
    }

    protected function _getMenuItemClasses(Varien_Data_Tree_Node $item)
    {
        $classes = array();

        $classes[] = 'level' . $item->getLevel();
        $classes[] = $item->getPositionClass();

        if ($item->getIsActive()) {
            $classes[] = 'active';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        if($item->getId()){
            $classes[] = $item->getId();
        }

        if ($this->getHasDropdownContent($item)) {
            $classes[] = 'parent';
        }

        return $classes;
    }

    protected function getHasDropdownContent(Varien_Data_Tree_Node $item)
    {
        $hasContent = false;

        if(!$item->hasColumns()):
            return false;
        endif;

        $columns = $item->getColumns();

        foreach($columns as $column){
            if(!empty($column['content'])):
                if($column['col_width'] != 0) {
                    $hasContent = true;
                }
            endif;
        }
        return $hasContent;
    }

    protected function getCategoryLiClass($category){
        $hasChildren = ($category->hasChildren()) ? ' has-children' : '';

        $class = 'level'.$category->getLevel();
        $class .= $hasChildren;

        return $class;
    }

    protected function setCategoryData($category,$parentLevel)
    {
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $category->setLevel($childLevel);
        $category->setHasDropDownContent($this->getHasDropdownContent($category));
    }

    protected function getMenuDropDownTypeClass($category)
    {
        $dropdownTypeId = $category->getMenuDropdownType();

        switch ($dropdownTypeId) {
            case 1:
                $dropdownClass = 'megamenu absolute-center';
                break;
            case 2:
                $dropdownClass = 'megamenu absolute-left';
                break;
            case 3:
                $dropdownClass = 'megamenu absolute-right';
                break;
            case 4:
                $dropdownClass = 'megamenu relative-center';
                break;
            case 5:
                $dropdownClass = 'megamenu hang-right';
                break;
            case 6:
                $dropdownClass = 'megamenu hang-left';
                break;
            default:
                $dropdownClass = 'megamenu absolute-center';
                break;
        }

        $dropdownClass .= ' level'.$category->getLevel();
        $dropdownClass .= ' xlab_grid_container';

        return $dropdownClass;
    }

    protected function getDropDownInlineStyle($child){

        $style = '';

        if($child->getMenuDropdownWidth() != null)
        {
            $style .= ' width:'.$child->getMenuDropdownWidth().';';
        }

        return $style;
    }

    protected function _isCategoryPlaceholder($category){
        return $category->getMenuLinkType() == TheExtensionLab_MegaMenu_Model_Config_Source_Link_Type::NO_LINK;
    }

    private function _getMegaMenuHelper()
    {
        return Mage::helper('theextensionlab_megamenu');
    }
}