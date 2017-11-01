<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Adminhtml_Attribute_Chooser extends
    Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($arguments = array())
    {
        parent::__construct($arguments);
        $this->setUseAjax(true);

    }

    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/menu_attribute_widget/chooser', array('uniq_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        if($element->hasValue())
        {
            $label = 'Multiple Options';
            $chooser->setLabel($label);

            $elementValue = $element->getValue();

            $sourceUrl = $this->getUrl('*/menu_attribute_option_widget/chooser', array('uniq_id' => $uniqId,'prev_value' => $elementValue));
            $chooser->setSourceUrl($sourceUrl);
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $newUrl = $this->getUrl('*/menu_attribute_option_widget/chooser', array('uniq_id' => $this->getId()));

        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var attributeId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                '.$chooserJsObject.'.close();
                '.$chooserJsObject.'.chooseNew("'.$newUrl.'?attribute_id=" + attributeId);
            }
        ';
        return $js;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addVisibleFilter();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('attribute_id', array(
            'header'=>Mage::helper('eav')->__('Attribute Id'),
            'sortable'=>true,
            'index'=>'attribute_id'
        ));

        $this->addColumn('attribute_code', array(
            'header'=>Mage::helper('eav')->__('Attribute Code'),
            'sortable'=>true,
            'index'=>'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header'=>Mage::helper('eav')->__('Attribute Label'),
            'sortable'=>true,
            'index'=>'frontend_label'
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/menu_attribute_widget/chooser', array('_current' => true));
    }
}