<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Adminhtml_Menu_Catalog_Category_Draggable_WidgetController
    extends Mage_Adminhtml_Controller_Action
{
    public function chooserAction()
    {
        $this->getResponse()->setBody(
            $this->_getCategoryTreeBlock()->toHtml()
        );
    }

    public function categoriesJsonAction()
    {
        if ($categoryId = (int)$this->getRequest()->getPost('id')) {

            $category = Mage::getModel('catalog/category')->load($categoryId);
            if ($category->getId()) {
                Mage::register('category', $category);
                Mage::register('current_category', $category);
            }
            $this->getResponse()->setBody(
                $this->_getCategoryTreeBlock()->getTreeJson($category)
            );
        }
    }

    private function _getCategoryTreeBlock()
    {
        $prevValue = $this->getRequest()->getParam('prev_value');
        return $this->getLayout()
            ->createBlock(
                'theextensionlab_megamenu/adminhtml_catalog_category_widget_draggable_chooser',
                '', array(
                    'id'         => $this->getRequest()->getParam('uniq_id'),
                    'prev_value' => $prevValue
                )
            );
    }


}