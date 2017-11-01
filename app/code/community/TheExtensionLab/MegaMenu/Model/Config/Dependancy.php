<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Config_Dependancy
{
    public function addCategoryFieldDependancys(Mage_Adminhtml_Block_Catalog_Category_Tab_Attributes $block)
    {
        $group = $block->getGroup();
        $groupId = $group->getAttributeGroupId();
        $groupName = $group->getAttributeGroupName();

        $dependanceBlock = $block->getLayout()->createBlock('adminhtml/widget_form_element_dependence');

        if($groupName == "MegaMenu Settings") {
            $this->_defineSettingsFieldDependancies($dependanceBlock, $groupId);
        }

        if($groupName == "MegaMenu Contents") {
            $this->_defineContentsFieldDependancies($dependanceBlock, $groupId);
        }

        Mage::dispatchEvent('define_megamenu_dependancies_after',array('dependaceBlock' => $dependanceBlock, 'block' => $block));

        $block->setChild('form_after', $dependanceBlock);
    }

    private function _defineSettingsFieldDependancies(Mage_Adminhtml_Block_Widget_Form_Element_Dependence $dependanceBlock, $groupId)
    {
        $dependanceBlock->addFieldMap("group_{$groupId}menu_dropdown_type", 'menu_dropdown_type')
            ->addFieldMap("group_{$groupId}menu_dropdown_width", 'menu_dropdown_width')
            ->addFieldMap("group_{$groupId}menu_link_type","menu_link_type")
            ->addFieldMap("group_{$groupId}menu_link","menu_link")
            ->addFieldDependence('menu_dropdown_width', 'menu_dropdown_type', array("2","3","4","5","6"))
            ->addFieldDependence('menu_link','menu_link_type', array("1","2"));
    }

    private function _defineContentsFieldDependancies(Mage_Adminhtml_Block_Widget_Form_Element_Dependence $dependanceBlock, $groupId)
    {
        $this->_addColumnsDependace($dependanceBlock, $groupId);
    }

    private function _addColumnsDependace($dependanceBlock, $groupId)
    {
        $columsType = Mage::helper('theextensionlab_megamenu/column_types')->getTypes();

        $valuesForActive = array();

        foreach($columsType as $columnType){
            for($i = 1;$i <= $columnType;$i++){
                $valuesForActive[] = "{$i}_{$columnType}";
            }
        }

        $totalColumnFeilds = (int) 7;

        for($i = 1;$i <= $totalColumnFeilds;$i++){
            $dependanceBlock->addFieldMap("group_{$groupId}menu_section_{$i}_column_width","menu_section_{$i}_column_width")
                ->addFieldMap("group_{$groupId}menu_section_{$i}_content","menu_section_{$i}_content")
                ->addFieldDependence("menu_section_{$i}_content","menu_section_{$i}_column_width", $valuesForActive);
        }
    }
}