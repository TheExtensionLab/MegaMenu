<?php

/** @var TheExtensionLab_MegaMenu_Model_Resource_Setup $this */
$installer = $this;

$installer->updateAttribute(
    Mage_Catalog_Model_Category::ENTITY,
    'menu_dropdown_type',
    'is_required',
    false
);

$installer->updateAttribute(
    Mage_Catalog_Model_Category::ENTITY,
    'menu_dropdown_type',
    'default_value',
    1
);

$installer->endSetup();