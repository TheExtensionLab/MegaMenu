<?php

/**
 * Derivative work based on Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser created by:
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

class TheExtensionLab_MegaMenu_Block_Adminhtml_Catalog_Category_Widget_Draggable_Chooser
    extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('theextensionlab/megamenu/widget/catalog/category/tree.phtml');
    }

    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl(
            '*/menu_catalog_category_draggable_widget/chooser',
            array('uniq_id' => $uniqId, 'use_massaction' => false)
        );

        $chooser = $this->getLayout()
            ->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        if($element->hasValue())
        {
            $label = 'Selected';
            $chooser->setLabel($label);

            $elementValue = $element->getValue();

            $sourceUrl = $this->getUrl(
                '*/menu_catalog_category_draggable_widget/chooser',
                array(
                    'uniq_id' => $uniqId,
                    'prev_value' => $elementValue,
                    'use_massaction' => false
                )
            );
            $chooser->setSourceUrl($sourceUrl);
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    public function getEmptyTreeJson($parenNodeCategory = null)
    {
        $prevValueJson = $this->getPrevValue();
        $prevValue = json_decode($prevValueJson);

        $rootArray = $this->_getNodeJson($this->getRoot($parenNodeCategory), 0);

        $oldChild = $rootArray['children']['0'];
        $rootArray['children'] = null;
        $rootArray['children']['0'] = $oldChild;
        $rootArray['children']['0']['children'] = null;

        if(!empty($prevValue->categories)):
            $prevValue->categories = $this->_addCategoryNameToPrevValueCategories($prevValue->categories);
            $rootArray['children']['0']['children'] = $prevValue->categories;
        endif;

        $rootArray['use_ajax'] = false;

        $rootArray['children']['0']['text'] = $this->__("Drag your categories here");
        $rootArray['children']['0']['id'] = 2;
        $json = Mage::helper('core')->jsonEncode(
            isset($rootArray['children'])
                ? $rootArray['children'] : array()
        );
        return $json;
    }

    private function _addCategoryNameToPrevValueCategories($categories)
    {
        $categoryCollection = $this->getCategoryCollection();
        foreach($categories as $categoryNode)
        {
            $category = $categoryCollection->getItemById($categoryNode->id);
            $categoryNode->text = $category->getName();

            if(!empty($categoryNode->children)){
                $this->_addCategoryNameToPrevValueCategories($categoryNode->children);
            }
        }

        return $categories;
    }

    public function getNodeClickListener()
    {
        $chooserJsObject = $this->getId();

        $js
            = '
            function (event) {
            ' . $chooserJsObject . '.setElementValue(

                        JSON.stringify(getNodeData(
                            tree2' . $this->getId() . '.getNodeById(2),
                            ["id","text"]
                        )).addSlashes()

            );
                ' . $chooserJsObject . '.setElementLabel("Selected");
                ' . $chooserJsObject . '.close();
            }


        ';

        return $js;
    }

}