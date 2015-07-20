<?php class TheExtensionLab_MegaMenu_Block_Adminhtml_Cms_Page_Edit_Tab_Menu extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $model = Mage::registry('cms_page');

        $fieldset = $form->addFieldset('main_feildset', array('legend' => $this->_getNameOfTab(), 'class' => 'fieldset-wide'));
        $this->_addElementTypes($fieldset);

        $fieldset->addField('menu_image', 'cms_menu_image', array(
            'name' => 'menu_image',
            'label' => $this->_getMegaMenuHelper()->__('Menu Image'),
            'title' => $this->_getMegaMenuHelper()->__('Menu Image')
        ));

        Mage::dispatchEvent('adminhtml_cms_page_edit_tab_menu_prepare_form', array('form' => $form));
        if($model) {
            $form->setValues($model->getData());
        }
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return $this->_getNameOfTab();
    }

    public function getTabTitle()
    {
        return $this->_getNameOfTab();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _getAdditionalElementTypes()
    {
        return array(
            'cms_menu_image' => 'TheExtensionLab_MegaMenu_Block_Adminhtml_Cms_Helper_Image'
        );
    }

    private function _getMegaMenuHelper()
    {
        return Mage::helper('theextensionlab_megamenu');
    }

    private function _getNameOfTab()
    {
        return $this->_getMegaMenuHelper()->__('MegaMenu Settings');
    }

}