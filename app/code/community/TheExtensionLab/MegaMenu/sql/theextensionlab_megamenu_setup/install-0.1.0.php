<?php

/** @var $installer TheExtensionLab_MegaMenu_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
$installer->installEntities();
$installer->endSetup();

$installer->addInstallationSuccessfulNotification();