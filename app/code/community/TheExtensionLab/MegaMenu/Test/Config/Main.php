<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Config_Main
    extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testClassAliases()
    {
        $this->assertBlockAlias(
            'theextensionlab_megamenu/block',
            'TheExtensionLab_MegaMenu_Block_Block'
        );
        $this->assertHelperAlias(
            'theextensionlab_megamenu',
            'TheExtensionLab_MegaMenu_Helper_Data'
        );
        $this->assertModelAlias(
            'theextensionlab_megamenu/example',
            'TheExtensionLab_MegaMenu_Model_Example'
        );
    }

    public function testSetupResources()
    {
        $this->assertSetupResourceDefined();
        $this->assertSetupResourceExists();
    }

    public function testFeaturedCmsWidgetNodeExists()
    {
        $widgetConfig = Mage::getModel('widget/widget');
        $widgetsArray = $widgetConfig->getWidgetsArray();


        $this->_assertArrayContainsFeaturedCmsBlock($widgetsArray);
    }

    private function _assertArrayContainsFeaturedCmsBlock($widgetsArray)
    {
        $configContainsCmsFeaturedWidget = false;
        foreach ($widgetsArray as $widget) {
            if ($widget['code'] == 'featured_cms_page_menu_block'
                && $widget['type'] == 'theextensionlab_megamenu/widget_cms_page_featured'
            ) {
                $configContainsCmsFeaturedWidget = true;
                break;
            }
        }
        $this->assertTrue($configContainsCmsFeaturedWidget);
    }

    public function testFeaturedCmsWidgetContainsParams()
    {
        $widgetConfig = Mage::getModel('widget/widget');
        $widgetXml = $widgetConfig->getWidgetsXml();
        foreach ($widgetXml as $code => $widget) {
            if ($code == 'featured_cms_page_menu_block') {
                $params = $widget->parameters;
                $reflection = new ReflectionObject($params);
                $this->assertTrue($reflection->hasProperty('title'));
                $this->assertTrue($reflection->hasProperty('menu_featured_cms_id'));
                $this->assertTrue($reflection->hasProperty('display_on'));
                $this->assertTrue($reflection->hasProperty('template'));
            }
        }
    }


}