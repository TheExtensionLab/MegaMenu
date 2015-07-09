<?php class TheExtensionLab_MegaMenu_Model_Parser extends Mage_Widget_Model_Template_Filter
{
    protected $_directiveValues = array();
    protected $_prefetchParsers = array();

    public function __construct($defaultParsers)
    {
        $this->setPrefetchParsers($defaultParsers);
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

        foreach ($this->_prefetchParsers as $modelAlias) {
            $this->getConfigDataToPrefetchFromConstruction($modelAlias, $params);
        }
    }

    private function getConfigDataToPrefetchFromConstruction($modelAlias, $params)
    {
        $parser = Mage::getModel($modelAlias);
        if ($this->parserHasRequiredMethods($parser)) {
            $prefetchedData = $parser->parseForPrefetchData($params);
            $this->_directiveValues = array_merge($this->_directiveValues, $prefetchedData);
        }
    }

    private function parserHasRequiredMethods($parser)
    {
        return is_callable(array($parser, 'parseForPrefetchData'));
    }

    protected function getPrefetchParsers()
    {
        return $this->_prefetchParsers;
    }

    protected function setPrefetchParsers($models)
    {
        $this->_prefetchParsers = $models;
    }
}