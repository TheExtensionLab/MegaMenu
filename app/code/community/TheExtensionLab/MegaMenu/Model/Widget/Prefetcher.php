<?php class TheExtensionLab_MegaMenu_Model_Widget_Prefetcher extends Mage_Widget_Model_Template_Filter
{
    protected $_dataToPrefetch = array();
    protected $_prefetchModels = array();
    protected $_prefetchParsers = array();


    public function __construct()
    {
        $this->_preparePrefetchModels();
    }

    private function _preparePrefetchModels()
    {
        $this->_prefetchParsers = array(
            'featured_product' => 'theextensionlab_megamenu/product_featured_parser',
            'attribute_option' => 'theextensionlab_megamenu/attribute_option_parser',
//            'url_rewrite'      => 'theextensionlab_megamenu/url_rewrite_parser'
        );

        $this->_prefetchModels = array(
            'product' => 'theextensionlab_megamenu/product_prefetcher',
            'attribute_option' => 'theextensionlab_megamenu/attribute_option_prefetcher',
            'attribute' => 'theextensionlab_megamenu/attribute_prefetcher',
//            'url_rewrite' => 'theextensionlab_megamenu/url_rewrite_prefetcher'
        );

        Mage::dispatchEvent('megamenu_prepare_prefetch_models_after', array('block' => $this));
    }

    public function getPrefetchModels()
    {
        return $this->_prefetchModels;
    }

    public function setPrefetchModels($models)
    {
        $this->_prefetchModels = $models;
    }

    public function getPrefetchParsers()
    {
        return $this->_prefetchParsers;
    }

    public function setPrefetchParsers($models)
    {
        $this->_prefetchParsers = $models;
    }

    public function prefetch($value)
    {
        if (preg_match_all(self::CONSTRUCTION_PATTERN, $value, $constructions, PREG_SET_ORDER)) {
            foreach ($constructions as $index => $construction) {
                $callback = array($this, $construction[1] . 'PrefetchDirective');
                if (!is_callable($callback)) {
                    continue;
                }
                try {
                    $replacedValue = call_user_func($callback, $construction);
                } catch (Exception $e) {
                    throw $e;
                }
                $value = str_replace($construction[0], $replacedValue, $value);
            }
        }

        $this->_prefetchWaitingData();

        return $value;
    }

    protected function widgetPrefetchDirective($construction)
    {
        $params = $this->_getIncludeParameters($construction[2]);

        foreach($this->_prefetchParsers as $modelAlias)
        {
            $model = Mage::getModel($modelAlias);
            if(is_callable(array($model,'saveDataToPrefetch'))) {
                $prefetchedData = $model->saveDataToPrefetch($params);
                $this->_dataToPrefetch = array_merge($this->_dataToPrefetch, $prefetchedData);
            }
        }
    }

    private function _prefetchWaitingData()
    {
        Varien_Profiler::start('megamenu_prefetch_and_store_data');

        foreach($this->_prefetchModels as $modelAlias)
        {
            $model = Mage::getModel($modelAlias);
            if(is_callable(array($model,'prefetchWaitingData'))) {
                $model->prefetchWaitingData($this->_dataToPrefetch);
            }
        }

        Varien_Profiler::stop('megamenu_prefetch_and_store_data');
    }
}