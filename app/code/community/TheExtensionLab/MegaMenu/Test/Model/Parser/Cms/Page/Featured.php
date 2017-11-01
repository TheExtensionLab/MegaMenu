<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Model_Parser_Cms_Page_Featured extends EcomDev_PHPUnit_Test_Case
{
    private $_featuredCmsParser;

    public function setUp()
    {
        $this->_featuredCmsParser = new TheExtensionLab_MegaMenu_Model_Parser_Cms_Page_Featured;
    }

    public function testImplementsParserInterface()
    {
        $class = new ReflectionClass('TheExtensionLab_MegaMenu_Model_Parser_Cms_Page_Featured');
        $this->assertTrue($class->implementsInterface('TheExtensionLab_MegaMenu_Model_Parser_Interface'));
    }

    public function testNoCmsIdReturnsEmptyArray()
    {
        $result = $this->_featuredCmsParser->parse($this->getIdsWithCmsId(''));
        $this->assertTrue(empty($result['cms_page_ids']));
    }

    public function testParamsWithCmsIdReturnThatCmsId()
    {
        $result = $this->_featuredCmsParser->parse($this->getIdsWithCmsId('1'));
        $this->assertTrue(in_array('1',$result['cms_page_ids']));
    }


    public function testParamsWithLargeCmsIdReturnThatCmsId()
    {
        $result = $this->_featuredCmsParser->parse($this->getIdsWithCmsId('17865358'));
        $this->assertTrue(in_array('17865358',$result['cms_page_ids']));
    }


    public function testParamsWithNumberSpellingIdDoesNotReturnThat()
    {
        $result = $this->_featuredCmsParser->parse($this->getIdsWithCmsId('one'));
        $this->assertTrue(empty($result['cms_page_ids']));
    }

    private function getIdsWithCmsId($cmsId)
    {
        return array(
            'type' => 'theextensionlab_megamenu/widget_cms_page_featured',
            'menu_featured_cms_id' => $cmsId,
            'display_on' => 'medium,large',
            'template' => 'sometemplate.phtml'
        );
    }
}