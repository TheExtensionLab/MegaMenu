<?php

/**
 * Derivative work based on Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser created by:
 * X.commerce, Inc. (http://www.magento.com)
 *
 * @copyright   Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 * Changes by:  TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 *
 */

class TheExtensionLab_MegaMenu_Block_Adminhtml_Catalog_Product_Widget_Chooser
extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
{

    public function __construct($arguments = array())
    {
        parent::__construct($arguments);
        $this->setSkipGenerateContent(true);
        if($this->getCallback()) {
            $this->setDefaultFilter(array('in_products' => 1));
        }
    }

    protected function _prepareLayout()
    {
        $this->setChild('submit_products_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Submit Products'),
                    'onclick'   => $this->getSubmitCallback(),
                    'class'   => 'task'
                ))
        );

        return parent::_prepareLayout();
    }

    protected function _prepareCollection()
    {
        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->setStoreId(0)
            ->addAttributeToSelect('name');

        if ($categoryId = $this->getCategoryId()) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            if ($category->getId()) {
                // $collection->addCategoryFilter($category);
                $productIds = $category->getProductsPosition();
                $productIds = array_keys($productIds);
                if (empty($productIds)) {
                    $productIds = 0;
                }
                $collection->addFieldToFilter('entity_id', array('in' => $productIds));
            }
        }

        if ($productTypeId = $this->getProductTypeId()) {
            $collection->addAttributeToFilter('type_id', $productTypeId);
        }


        $collection->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $collection->addAttributeToFilter('visibility', array('neq' => array(
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE
        )));


        $this->setCollection($collection);
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    protected function _afterLoadCollection()
    {
        foreach($this->getCollection() as $item) {
            if (isset($prevValue[$item->getEntityId()][0]['position'])) {
                $item->setPosition((int) $prevValue[$item->getEntityId()][0]['position']);
            }else{
                $item->setPosition(0);
            }
        }
        return $this;
    }


    protected function _setCollectionPositionValues($collection)
    {
        $prevValue = $this->getCallback();
        foreach($collection as $item) {
            if (isset($prevValue[$item->getEntityId()][0]['position'])) {
                $item->setPosition((int) $prevValue[$item->getEntityId()][0]['position']);
            }else{
                $item->setPosition(0);
            }
        }
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_products') {
            $this->_setCustomFilterForInProductFlag($column);
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    private function _setCustomFilterForInProductFlag($column)
    {
        $productIds = $this->_getSelectedProducts();
        if (empty($productIds)) {
            $productIds = 0;
        }
        if ($column->getFilter()->getValue()) {
            $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
        } else {
            if($productIds) {
                $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
            }
        }
    }

    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $chooser = $this->_getChooserWithCustomSourceUrl($element,$uniqId);

        if($element->hasValue())
        {
            $label = 'Selected Products';
            $chooser->setLabel($label);

            $elementValue = $element->getValue();

            $sourceUrl = $this->getUrl('*/menu_catalog_product_widget/chooser', array('uniq_id' => $uniqId,'selected_products' => $elementValue));
            $chooser->setSourceUrl($sourceUrl);
        }
        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    private function _getChooserWithCustomSourceUrl(Varien_Data_Form_Element_Abstract $element,$uniqId)
    {
        $sourceUrl = $this->getUrl(
            '*/menu_catalog_product_widget/chooser', array(
                'uniq_id'        => $uniqId
            )
        );

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        return $chooser;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('in_products', array(
            'header_css_class' => 'a-center',
            'type'      => 'checkbox',
            'name'      => 'in_products',
            'inline_css' => 'checkbox entities',
            'values'    => $this->_getSelectedProducts(),
            'align'     => 'center',
            'index'     => 'entity_id'
        ));

        $this->addColumnAfter(
            'position', array(
                'header'         => Mage::helper('eav')->__('Position'),
                'name'           => 'position',
                'type'           => 'number',
                'validate_class' => 'validate-number',
                'width'          => '1',
                'editable'       => true,
                'index'          => 'position'
            ),'chooser_name'
        );

        parent::_prepareColumns();
    }

    public function getSelectedProducts()
    {
        if ($selectedProducts = $this->getRequest()->getParam('selected_products', null)) {
            $this->setSelectedProducts($selectedProducts);
        }
        return $this->_selectedProducts;
    }

    public function getSubmitProductsButtonHtml()
    {
        return $this->getChildHtml('submit_products_button');
    }


    public function getMainButtonsHtml()
    {
        $html = '';

        if($this->getFilterVisibility()){
            $html.= $this->getResetFilterButtonHtml();
            $html.= $this->getSearchButtonHtml();
        }

        $html.= $this->getSubmitProductsButtonHtml();

        return $html;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/menu_catalog_product_widget/chooserGridOnly', array(
            'products_grid' => true,
            '_current' => true,
            'uniq_id' => $this->getId(),
            'use_massaction' => $this->getUseMassaction(),
            'product_type_id' => $this->getProductTypeId()
        ));
    }

    public function getSubmitCallback()
    {
        $chooserJsObject = $this->getId();

        $js = '
                '.$chooserJsObject.'.setElementValue(document.getElementsByName(\'megamenu_featured_products\')[0].value);
                '.$chooserJsObject.'.setElementLabel(\'Selected Products\');
                '.$chooserJsObject.'.close();
            ';

        return $js;
    }

    public function getRowClickCallback()
    {
        return '';
    }

    private function _getSelectedProducts()
    {
        $productIds = array();
        if($this->getCallback()) {
            $prevValueArray = $this->getCallback();
            $productIds = array_keys($prevValueArray);
        }
        return $productIds;
    }


    public function getCallback()
    {
        if(!is_string($this->getSelectedProducts()))
        {
            return false;
        }
        return json_decode($this->getSelectedProducts(),1);
    }
}