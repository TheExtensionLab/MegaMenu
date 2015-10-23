<?php
$installer = $this;

$installer->startSetup();

//We have new attribute and need to reindex if flat categories are enabled.
$categoryFlatIndexer =  Mage::getModel('index/indexer')
    ->getProcessByCode(Mage_Catalog_Helper_Category_Flat::CATALOG_CATEGORY_FLAT_PROCESS_CODE);

if(Mage::getModel('catalog/category_flat')->isEnabled()){
    $categoryFlatIndexer->reindexAll();
}else{
    $categoryFlatIndexer->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
}

$installer->endSetup();