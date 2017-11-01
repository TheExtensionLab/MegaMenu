<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Parser extends Mage_Widget_Model_Template_Filter
{
    private $_directiveValues = array();
    private $_parsers = array();

    public function __construct($defaultParsers)
    {
        $this->_parsers = $defaultParsers;
    }

    public function getDirectiveValues($value)
    {
        if ($constructions = $this->_matchConstructionPattern($value)) {
            foreach ($constructions as $index => $construction) {
                $this->_callPrefetchDirective($construction);
            }
        }

        return $this->_directiveValues;
    }

    public function _matchConstructionPattern($value)
    {
        preg_match_all(self::CONSTRUCTION_PATTERN, $value, $constructions, PREG_SET_ORDER);
        return $constructions;
    }

    public function setChildParser($key,$modelAlias){
        $this->_parsers[$key] = $modelAlias;
    }

    private function _callPrefetchDirective($construction)
    {
        $callback = array($this, $construction[1] . 'PrefetchDirective');
        if ($this->isDirectiveIsCallable($callback)) {
            call_user_func($callback, $construction);
        }
    }

    private function isDirectiveIsCallable($callback)
    {
        return is_callable($callback);
    }

    private function widgetPrefetchDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);

        foreach ($this->_parsers as $modelAlias) {
            $this->getConfigDataToPrefetchFromConstruction($modelAlias, $params);
        }
    }

    private function getConfigDataToPrefetchFromConstruction($modelAlias, $params)
    {
        $parser = Mage::getModel($modelAlias);
        if ($this->isMegaMenuParserInstance($parser)) {
            $directiveValues = $parser->parse($params);
            $this->_directiveValues = array_merge_recursive($this->_directiveValues, $directiveValues);
        }
    }

    private function isMegaMenuParserInstance($parser)
    {
        return $parser instanceof TheExtensionLab_MegaMenu_Model_Parser_Interface;
    }
}