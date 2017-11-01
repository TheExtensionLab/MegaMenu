<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Adminhtml_Menu_Catalog_Product_WidgetController
    extends Mage_Adminhtml_Controller_Action
{
    public function chooserAction()
    {
        $this->loadLayout();

        $this->getLayout()->getBlock('root')->append($this->_initGrid());

        $serializer = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer', 'megamenu_featured_products_grid_serializer')
            ->setTemplate('theextensionlab/megamenu/widget/grid/json/serializer.phtml')
        ;
        $serializer->initSerializerBlock(
            'adminhtml.megamenu.catalog.product.widget.grid',
            'getCallback',
            'megamenu_featured_products',
            'selected_products'
        );
        $serializer->addColumnInputName(
            array(
                'in_products',
                'position'
            )
        );

        $this->getLayout()->getBlock('root')->append($serializer);

        $this->renderLayout();
    }

    public function chooserGridOnlyAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('root')->append($this->_initGrid());
        $this->renderLayout();
    }

    private function _initGrid()
    {
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $selectedProducts = $this->getRequest()->getParam('selected_products');

        $grid = $this->getLayout()->createBlock(
            'theextensionlab_megamenu/adminhtml_catalog_product_widget_chooser',
            'adminhtml.megamenu.catalog.product.widget.grid', array(
                'id'         => $uniqId,
                'selected_products' => $selectedProducts
            )
        );

        return $grid;
    }
}