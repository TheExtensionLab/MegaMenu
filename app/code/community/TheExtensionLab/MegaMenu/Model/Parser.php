<?php class TheExtensionLab_MegaMenu_Model_Parser extends Mage_Widget_Model_Template_Filter
{
    protected $_directiveValues = array();
    protected $_parsers = array();

    public function __construct($defaultParsers)
    {
        $this->setParsers($defaultParsers);
    }

    public function getDirectiveValues($value)
    {
        if ($constructions = $this->_matchConstructorPattern($value)) {
            foreach ($constructions as $index => $construction) {
                $this->_callPrefetchDirective($construction);
            }
        }

        return $this->_directiveValues;
    }

    private function _matchConstructorPattern($value)
    {
        preg_match_all(self::CONSTRUCTION_PATTERN, $value, $constructions, PREG_SET_ORDER);
        return $constructions;
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
            $this->_directiveValues = array_merge($this->_directiveValues, $directiveValues);
        }
    }

    private function isMegaMenuParserInstance($parser)
    {
        return $parser instanceof TheExtensionLab_MegaMenu_Model_Parser_Interface;
    }

    protected function getParsers()
    {
        return $this->_parsers;
    }

    protected function setParsers($models)
    {
        $this->_parsers = $models;
    }
}