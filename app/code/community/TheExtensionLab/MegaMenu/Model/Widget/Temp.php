private function _preFetchAttributeOptionsCollection()
{
$optionIdArray = array();
$storeId = Mage::app()->getStore()->getStoreId();

$collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
->addFieldToFilter('main_table.option_id', array('in' => $this->_dataToPrefetch['option_ids']))
->setStoreFilter($storeId, true);

foreach($collection as $option)
{
$optionIdArray[$option->getOptionId()] = $option;
$this->_dataToPrefetch['attribute_ids'] = $option->getAttributeId();
}

Mage::register('megamenu_attribute_options',$optionIdArray);
}

private function _preFetchAttributesCollection()
{
$attributeIdArray = array();
$collection = Mage::getResourceModel('catalog/product_attribute_collection')
->addVisibleFilter();

foreach($collection as $attribute)
{
$attributeIdArray[$attribute->getAttributeId()] = $attribute;
}

Mage::register('megamenu_attributes',$attributeIdArray);
}

private function _preFetchFeaturedProducts()
{
if (isset($this->_dataToPrefetch['product_ids'])) {
$featuredProductLimit = 20;

$featuredProductsCollection = Mage::getModel('catalog/product')->getCollection()
->addAttributeToFilter('entity_id', array('in' => $this->_dataToPrefetch['product_ids']))
->addAttributeToSelect(array('name', 'menu_image', 'price', 'special_price', 'url_key'))
->setPageSize($featuredProductLimit)
->load()
;

Mage::register('megamenu_products_collection', $featuredProductsCollection);
}
}

protected function _preFetchFilterUrlrewrites()
{
Varien_Profiler::start('megamenu_url_rewrites_prefetching');
$rewriteCollectionByIdPath = array();
$rewritesCollection = Mage::getModel('core/url_rewrite')->getCollection()
->addFieldToFilter('id_path',array('in' => $this->_dataToPrefetch['rewrite_ids']));


foreach($rewritesCollection as $rewrite)
{
$rewriteCollectionByIdPath[$rewrite->getIdPath()] = $rewrite;
}

Mage::register('megamenu_url_rewrites',$rewriteCollectionByIdPath);
Varien_Profiler::stop('megamenu_url_rewrites_prefetching');
}