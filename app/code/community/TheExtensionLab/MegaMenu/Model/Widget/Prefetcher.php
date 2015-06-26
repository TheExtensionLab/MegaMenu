<?php class TheExtensionLab_MegaMenu_Model_Widget_Prefetcher extends Mage_Widget_Model_Template_Filter
{
    protected $_dataToPrefetch = array();

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

        if (isset($params['megamenu_featured_products_ids'])) {
            $featuredProductIds = explode(',', $params['megamenu_featued_products_ids']);
            $this->_dataToPrefetch['product_ids'] = array_merge(
                $featuredProductIds, $this->_dataToPrefetch['product_ids']
            );
        }

        if(isset($params['option_ids'])) {
            $optionIds = Mage::helper('adminhtml/js')->decodeGridSerializedInput($params['option_ids']);
            foreach($optionIds as $key => $value):
                $this->_dataToPrefetch['option_ids'][] = $key;

                if(isset($params['category_id'])):
                    $this->_dataToPrefetch['rewrite_ids'][] = 'category/'.$params['category_id'];
                endif;
            endforeach;
        }

    }

    private function _prefetchWaitingData()
    {
        Varien_Profiler::start('megamenu_prefetch_and_store_data');
        $this->_preFetchFeaturedProducts();
        Varien_Profiler::stop('megamenu_prefetch_and_store_data');
    }


    private function _preFetchFeaturedProducts()
    {
        if (isset($this->_dataToPrefetch['product_ids'])) {
            $featuredProductsById = array();

            $featuredProductLimit = 20;

            $featuredProductsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $this->_dataToPrefetch['product_ids']))
                ->addAttributeToSelect(array('name', 'menu_image', 'price', 'special_price', 'url_key'))
                ->setPageSize($featuredProductLimit);

            foreach ($featuredProductsCollection as $featuredProduct) {
                $featuredProductsById[$featuredProduct->getId()] = $featuredProduct;
            }

            Mage::register('menu_featured_products_collection', $featuredProductsById);
        }
    }
}