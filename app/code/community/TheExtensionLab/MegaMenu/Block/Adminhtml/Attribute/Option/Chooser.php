<?php

class TheExtensionLab_MegaMenu_Block_Adminhtml_Attribute_Option_Chooser extends
    Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($arguments = array())
    {
        parent::__construct($arguments);
        $this->setUseAjax(true);
        $this->setSkipGenerateContent(true);
    }

    protected function _prepareLayout()
    {
        $this->setChild('submit_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Submit Options'),
                    'onclick'   => $this->getSubmitCallback(),
                    'class'   => 'task'
                ))
        );

        $this->setChild('back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Back'),
                    'onclick'   => $this->getBackCallback(),
                    'class'   => 'back'
                ))
        );

        return parent::_prepareLayout();
    }

    private function getBackCallback()
    {
        $chooserJsObject = $this->getId();
        $newUrl = $this->getUrl('*/menu_attribute_widget/chooser', array('uniq_id' => $this->getId()));

        $js = '
                '.$chooserJsObject.'.close();
                '.$chooserJsObject.'.chooseNew(\''.$newUrl.'\');
            ';

        return $js;
    }

    public function getSubmitCallback()
    {
        $chooserJsObject = $this->getId();

        $js = '
                '.$chooserJsObject.'.setElementValue(document.getElementsByName(\'megamenu_attribute_options\')[0].value);
                '.$chooserJsObject.'.setElementLabel(\'Multiple Options\');
                '.$chooserJsObject.'.close();
            ';

        return $js;
    }

    public function getBackButtonHtml()
    {
        return $this->getChildHtml('back_button');
    }

    public function getSubmitButtonHtml()
    {
        return $this->getChildHtml('submit_button');
    }


    public function getMainButtonsHtml()
    {
        $html = '';

        $html.= $this->getBackButtonHtml();

        if($this->getFilterVisibility()){
            $html.= $this->getResetFilterButtonHtml();
            $html.= $this->getSearchButtonHtml();
        }

        $html.= $this->getSubmitButtonHtml();

        return $html;
    }

    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/menu_attribute_option_widget/chooser', array('uniq_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    protected function _prepareCollection()
    {
        $attributeId = $this->getAttributeId();

        $storeId = Mage::app()->getStore()->getStoreId();
        $collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attributeId)
            ->setStoreFilter($storeId, false);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'use_options', array(
                'header_css_class' => 'a-center',
                'type'             => 'checkbox',
                'name'             => 'use_options',
                'values'           => $this->_getSelectedOptions(),
                'align'            => 'center',
                'index'            => 'option_id'
            )
        );

        $this->addColumn('option_id', array(
            'header'=>Mage::helper('eav')->__('Option Id'),
            'index'=>'option_id',
            'width'  => '80px'
        ));

        $this->addColumn('value', array(
            'header'=>Mage::helper('eav')->__('Option Value'),
            'index'=>'value'
        ));

        $this->addColumn(
            'position', array(
                'header'         => Mage::helper('eav')->__('Position'),
                'name'           => 'position',
                'type'           => 'number',
                'validate_class' => 'validate-number',
                'width'          => '1',
                'editable'       => true,
                'value'          => '0'
            )
        );


        return parent::_prepareColumns();
    }

    private function _getSelectedOptions()
    {
        $prevValueArray = get_object_vars($this->getCallback());
        $optionIds = array_keys($prevValueArray);
        return $optionIds;
    }


    public function getCallback()
    {
        return json_decode($this->getPrevValue());
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/menu_attribute_option_widget/chooserGridOnly', array('_current' => true));
    }


}