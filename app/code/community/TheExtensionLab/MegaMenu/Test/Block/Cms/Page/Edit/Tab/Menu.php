<?php class TheExtensionLab_MegaMenu_Test_Block_Cms_Page_Edit_Tab_Menu extends EcomDev_PHPUnit_Test_Case
{
    public function testImplementsTabInterface()
    {
        $class = new ReflectionClass('TheExtensionLab_MegaMenu_Block_Adminhtml_Cms_Page_Edit_Tab_Menu');
        $this->assertTrue($class->implementsInterface('Mage_Adminhtml_Block_Widget_Tab_Interface'));
    }
}