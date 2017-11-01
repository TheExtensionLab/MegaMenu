<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Block_Widget_Cms_Page_Featured extends EcomDev_PHPUnit_Test_Case
{
    public function testFeaturedBlockImplementsWidgetBlockInterface()
    {
        $class = new ReflectionClass('TheExtensionLab_MegaMenu_Block_Widget_Cms_Page_Featured');
        $this->assertTrue($class->implementsInterface('Mage_Widget_Block_Interface'));
    }
}