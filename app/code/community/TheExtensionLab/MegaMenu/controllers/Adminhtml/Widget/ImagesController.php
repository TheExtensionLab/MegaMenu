<?php
require_once 'Mage' . DS . 'Adminhtml' . DS . 'controllers' . DS . 'Cms' . DS . 'Wysiwyg' . DS . 'ImagesController.php';

class TheExtensionLab_MegaMenu_Adminhtml_Widget_ImagesController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController
{
    /**
     * Fire when select image
     */
    public function onInsertAction()
    {
        $helper = Mage::helper('theextensionlab_megamenu/widget_images');
        $storeId = $this->getRequest()->getParam('store');

        $filename = $this->getRequest()->getParam('filename');
        $filename = $helper->idDecode($filename);
        $asIs = $this->getRequest()->getParam('as_is');

        Mage::helper('catalog')->setStoreId($storeId);
        $helper->setStoreId($storeId);

        $image = $helper->getImageWithPath($filename, $asIs);
        $this->getResponse()->setBody($image);
    }
}