<?php class TheExtensionLab_MegaMenu_Block_Adminhtml_Widget_Image_Chooser extends Mage_Adminhtml_Block_Template
{
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/widget_images/index',
            array('uniq_id' => $uniqId, 'use_massaction' => false, 'target_element_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        if ($element->getValue()) {
            $value = explode('/', $element->getValue());

                $chooser->setLabel('boom!');

        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }
}