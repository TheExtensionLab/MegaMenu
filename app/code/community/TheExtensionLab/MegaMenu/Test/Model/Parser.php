<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Test_Model_Parser extends PHPUnit_Framework_TestCase
{
    private $parser;

    public function setUp()
    {
        $defaultParsers = array(
            'featured_product' => 'theextensionlab_megamenu/parser_product_featured',
            'attribute_option' => 'theextensionlab_megamenu/parser_attribute_option',
            'url_rewrite'      => 'theextensionlab_megamenu/parser_url_rewrite'
        );

        $this->parser = new TheExtensionLab_MegaMenu_Model_Parser($defaultParsers);
    }

    public function testCanGetDirectiveValues()
    {
        $this->assertTrue(method_exists($this->parser,'getDirectiveValues'));
    }

    public function testCanMatchConstructionPattern()
    {
        $exampleValue = '{{widget type="theextensionlab_megamenu/widget_category_featured" menu_featured_category_id="4" }}';
        $isMatchEmpty = $this->_isValueAMatch($exampleValue);
        $this->assertFalse($isMatchEmpty);
    }

    public function testConstructionPatternNotMatchedIncorrectly()
    {
        $exampleValue = '{/;}}{[{A None Matching String }}[[';
        $isMatchEmpty = $this->_isValueAMatch($exampleValue);
        $this->assertTrue($isMatchEmpty);
        $this->assertTrue($isMatchEmpty);
    }

    public function testConstructonMatcherGetsCorrectShortcodeType()
    {
        $exampleValue = '{{widget type="someBlock"}}';
        $match = $this->_getMatches($exampleValue);
        $this->assertEquals('widget', $match['0']['1']);
    }

    public function testConstructionMatcherGetsParamString()
    {
        $exampleValue = '{{widget type="theextensionlab_megamenu/widget_category_featured" menu_featured_category_id="4" }}';
        $match = $this->_getMatches($exampleValue);
        $matchedParamString = trim($match[0][2]);
        $this->assertEquals('type="theextensionlab_megamenu/widget_category_featured" menu_featured_category_id="4"',$matchedParamString);
    }

    public function testGetDirectiveValuesStoresSomeData()
    {
        $exampleValue = '{{widget type="theextensionlab_megamenu/widget_product_featured"
         display_on="small,medium,large" template="theextensionlab/megamenu/products/featured.phtml"
          megamenu_featured_product_ids="{\"231\":[{\"position\":\"0\"}],\"232\":[{\"position\":\"0\"}]}"}}';
        $directiveValues = $this->parser->getDirectiveValues($exampleValue);
        $this->assertTrue(!empty($directiveValues));
    }

    private function _isValueAMatch($value)
    {
        $isMatchEmpty = empty($this->_getMatches($value));
        return $isMatchEmpty;
    }

    private function _getMatches($value){
        $exampleValue = $value;
        $match = $this->parser->_matchConstructionPattern($exampleValue);
        return $match;
    }
}