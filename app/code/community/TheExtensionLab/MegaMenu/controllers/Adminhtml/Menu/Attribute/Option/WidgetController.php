<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Adminhtml_Menu_Attribute_Option_WidgetController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _getAttributeIdFromFirstPrevValue($prevValue)
    {
        $optionIds = json_decode($prevValue,1);
        $first_key = key($optionIds);
        $option = Mage::getModel('eav/entity_attribute_option')->load($first_key);

        return $option->getAttributeId();
    }

    /**
     * Chooser Source action
     */
    public function chooserAction()
    {
        $this->loadLayout();
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $prevValue = $this->getRequest()->getParam('prev_value');
        $attributeId = $this->getRequest()->getParam('attribute_id');

        if($attributeId === null && $prevValue != null)
        {
            $attributeId = $this->_getAttributeIdFromFirstPrevValue($prevValue);
        }

        $grid = $this->getLayout()->createBlock('theextensionlab_megamenu/adminhtml_attribute_option_chooser', 'adminhtml.megamenu.attribute.option.widget.grid', array(
            'id' => $uniqId,
            'prev_value' => $prevValue,
            'attribute_id' => $attributeId
        ));

        $this->getLayout()->getBlock('root')->append($grid);

        $serializer = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer','grouped_grid_serializer')
            ->setTemplate('theextensionlab/megamenu/widget/grid/json/serializer.phtml')
        ;
        $serializer->initSerializerBlock(
            'adminhtml.megamenu.attribute.option.widget.grid',
            'getCallback',
            'megamenu_attribute_options',
            'selected_options'
        );
        $serializer->addColumnInputName(array(
            'use_options',
            'position'
        ));

        $this->getLayout()->getBlock('root')->append($serializer);

        $this->renderLayout();
    }

    public function chooserGridOnlyAction()
    {
        $this->loadLayout();
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $attributeId = $this->getRequest()->getParam('attribute_id');

        $grid = $this->getLayout()->createBlock('theextensionlab_megamenu/adminhtml_attribute_option_chooser', 'adminhtml.megamenu.attribute.option.widget.grid', array(
            'id' => $uniqId,
            'attribute_id' => $attributeId
        ))->setSelectedOptions($this->getRequest()->getPost('selected_options', null));

        $this->getLayout()->getBlock('root')->append($grid);

        $this->renderLayout();
    }
}