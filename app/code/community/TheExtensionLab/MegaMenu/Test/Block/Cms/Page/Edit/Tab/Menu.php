<?php class TheExtensionLab_MegaMenu_Test_Block_Cms_Page_Edit_Tab_Menu extends EcomDev_PHPUnit_Test_Case_Controller
{
    public function testImplementsTabInterface()
    {
        $class = new ReflectionClass('TheExtensionLab_MegaMenu_Block_Adminhtml_Cms_Page_Edit_Tab_Menu');
        $this->assertTrue($class->implementsInterface('Mage_Adminhtml_Block_Widget_Tab_Interface'));
    }

    public function testFormIsVarienDataForm()
    {
        $menuTab = $this->getLayout()->createBlock('theextensionlab_megamenu/adminhtml_cms_page_edit_tab_menu');
        $menuTab->toHtml();
        $form = $menuTab->getForm();
        $this->assertTrue($form instanceof Varien_Data_Form);
    }

    public function testFormHasImageField()
    {
        $menuTab = $this->getLayout()->createBlock('theextensionlab_megamenu/adminhtml_cms_page_edit_tab_menu');
        $menuTab->toHtml();
        $form = $menuTab->getForm();
        $element = $form->getElement('menu_image');
        $this->assertNotNull($element);
    }
}