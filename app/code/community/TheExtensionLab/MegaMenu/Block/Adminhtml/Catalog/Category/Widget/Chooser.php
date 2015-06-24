<?php class TheExtensionLab_MegaMenu_Block_Adminhtml_Catalog_Category_Widget_Chooser
extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser
{
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $chooser = $this->getChooserWithCustomSourceUrl($element);

        if ($element->getValue()) {
            $categoryId = false;
            if ($element->hasValue()) {
                $categoryId = $element->getValue();
            }
            if ($categoryId) {
                $label = $this->_getModelAttributeByEntityId('catalog/category', 'name', $categoryId);
                $chooser->setLabel($label);
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    public function getNodeClickListener()
    {
        $js = parent::getNodeClickListener();

        if(!$this->getData('node_click_listener') && !$this->getUseMassaction())
        {
            $chooserJsObject = $this->getId();
            $js = $this->_getJsWithoutCategoryPrefix($chooserJsObject);
        }

        return $js;
    }

    private function _getJsWithoutCategoryPrefix($chooserJsObject)
    {
        $js = '
                function (node, e) {
                    '.$chooserJsObject.'.setElementValue(node.attributes.id);
                    '.$chooserJsObject.'.setElementLabel(node.text);
                    '.$chooserJsObject.'.close();
                }
        ';

        return $js;
    }

    private function getChooserWithCustomSourceUrl(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());

        $sourceUrl = $this->getUrl('*/menu_catalog_category_widget/chooser',
            array('uniq_id' => $uniqId, 'use_massaction' => false));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        return $chooser;
    }
}