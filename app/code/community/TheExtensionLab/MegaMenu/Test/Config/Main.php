<?php
/**
 * MegaMenu Main Configuration Tests
 *
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */
class TheExtensionLab_MegaMenu_Test_Config_Main
    extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testClassAliases()
    {
        $this->assertBlockAlias(
            'theextensionlab_megamenu/block',
            'TheExtensionLab_MegaMenu_Block_Block'
        );
        $this->assertHelperAlias(
            'theextensionlab_megamenu',
            'TheExtensionLab_MegaMenu_Helper_Data'
        );
        $this->assertModelAlias(
            'theextensionlab_megamenu/example',
            'TheExtensionLab_MegaMenu_Model_Example'
        );
    }

    public function testSetupResources()
    {
        $this->assertSetupResourceDefined();
        $this->assertSetupResourceExists();
        $this->assertSetupScriptVersions();
    }
}