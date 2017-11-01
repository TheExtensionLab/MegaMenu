<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_NODE_MENU_TEMPLATE_FILTER = 'global/theextensionlab_megamenu/menu/tempate_filter';
    const XML_NODE_MENU_WIDGET_PREFETCHER = 'global/theextensionlab_megamenu/menu/widget_prefetcher';

    public function getMenuTemplateProcessor()
    {
        $model = (string)Mage::getConfig()->getNode(self::XML_NODE_MENU_TEMPLATE_FILTER);
        return Mage::getModel($model);
    }

    public function getMenuWidgetPrefetcher()
    {
        $model = (string)Mage::getConfig()->getNode(self::XML_NODE_MENU_WIDGET_PREFETCHER);
        return Mage::getModel($model);
    }
}