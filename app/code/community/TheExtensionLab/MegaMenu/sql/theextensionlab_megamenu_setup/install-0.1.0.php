<?php

/** @var $installer TheExtensionLab_MegaMenu_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$installer->installEntities();

$connection = $installer->getConnection();
$cmsPageTable = $installer->getTable('cms/page');
$connection->addColumn($cmsPageTable, 'menu_image', "VARCHAR(255) default NULL AFTER `content`");

$installer->endSetup();

$installer->addInstallationSuccessfulNotification();