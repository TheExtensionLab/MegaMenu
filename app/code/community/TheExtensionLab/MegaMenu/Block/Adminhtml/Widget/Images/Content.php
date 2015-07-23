<?php class TheExtensionLab_MegaMenu_Block_Adminhtml_Widget_Images_Content extends Mage_Adminhtml_Block_Cms_Wysiwyg_Images_Content
{
    /**
     * Block construction
     */
    public function __construct()
    {
        parent::__construct();
        $this->_addButton('insert_files', array(
            'class'   => 'save no-display',
            'label'   => $this->helper('cms')->__('Insert File'),
            'type'    => 'button',
            'onclick' => $this->onInsertCallback(),
            'id'      => 'button_insert_files'
        ));
    }

    private function onInsertCallback()
    {
        $params = Mage::app()->getRequest()->getParams();
        $chooserJsObject = Mage::app()->getRequest()->getParam('uniq_id');
        $js = '
            MediabrowserInstance.getValueToInsertIntoWidget('.$chooserJsObject.');
        ';

        return $js;
    }
}