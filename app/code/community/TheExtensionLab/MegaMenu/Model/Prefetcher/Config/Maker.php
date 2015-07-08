<?php class TheExtensionLab_MegaMenu_Model_Prefetcher_Config_Maker extends Mage_Widget_Model_Template_Filter
{
    protected $_prefetchConfig = array();
    protected $_prefetchParsers = array();

    public function __construct()
    {
        $this->prepareParsers();
    }

    public function prepareConfig($value)
    {
        if ($constructions = $this->_matchConstructorPattern($value)) {
            foreach ($constructions as $index => $construction) {
                $this->_callPrefetchDirective($construction);
            }
        }

        return $this->_prefetchConfig;
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
            $this->_prefetchConfig = array_merge($this->_prefetchConfig, $prefetchedData);
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

    public function prepareParsers()
    {
        $this->setPrefetchParsers(
            array(
                'featured_product' => 'theextensionlab_megamenu/parser_product_featured',
                'attribute_option' => 'theextensionlab_megamenu/parser_attribute_option',
                'url_rewrite'      => 'theextensionlab_megamenu/parser_url_rewrite'
            )
        );
    }
}