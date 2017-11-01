<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Model_Resource_Setup
    extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testSetupAttributeContainsContentColumns()
    {
        $setupModel = Mage::getModel('theextensionlab_megamenu/resource_setup','theextensionlab_megamenu_setup');

        $defaultEntites = $setupModel->getDefaultEntities();
        $attributes = $defaultEntites['catalog_category']['attributes'];

        $this->assertArrayHasKey('menu_section_2_content',$attributes);
        $this->assertArrayHasKey('menu_section_2_column_width',$attributes);

        $this->assertArrayHasKey('menu_section_7_content',$attributes);
        $this->assertArrayHasKey('menu_section_7_column_width',$attributes);

    }
}