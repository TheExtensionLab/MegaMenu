<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Model_Menu_Attributes extends EcomDev_PHPUnit_Test_Case
{
    private $_attributesModel;

    public function setUp()
    {
        $this->_attributesModel = new TheExtensionLab_MegaMenu_Model_Menu_Attributes;
    }

    /**
     * @loadFixture
     */
    public function testAttributesConfigGetter()
    {
        $extraAttributes = $this->_getExtraAttributeByReflection();

        $this->assertTrue(in_array('a_test_attribute', $extraAttributes));
        $this->assertFalse(in_array('a_disabled_test_attribute', $extraAttributes));
    }

    private function _getExtraAttributeByReflection()
    {
        $reflectionClass = new \ReflectionClass('TheExtensionLab_MegaMenu_Model_Menu_Attributes');
        $reflectionMethod = $reflectionClass->getMethod('_getExtraAttributesFromConfig');
        $reflectionMethod->setAccessible(true);

        $reflectionProperty = $reflectionClass->getProperty('_extraAttributes');
        $reflectionProperty->setAccessible(true);

        $reflectionMethod->invokeArgs($this->_attributesModel, array());

        $extraAttributes = $reflectionProperty->getValue($this->_attributesModel);

        return $extraAttributes;
    }

    public function testExtraAttributesAddedToFlatSelect()
    {
        $mockSelect = $this->getMock('TheExtensionLab_MegaMenu_Test_Model_Menu_DbAdapterMock', array('columns'));
        $mockSelect->expects($this->once())
            ->method('columns');

        $this->_attributesModel->addExtraFlatAttributesToSelect($mockSelect);
    }

    public function testExtraAttributesAddedToEavSelect()
    {
        $mockCategoryCollection = $this->getMock(
            'TheExtensionLab_MegaMenu_Test_Model_Menu_CategoryCollectionMock', array('addAttributeToSelect')
        );
        $mockCategoryCollection->expects($this->atLeastOnce())
            ->method('addAttributeToSelect');

        $this->_attributesModel->addExtraAttributesToSelect($mockCategoryCollection);
    }
}