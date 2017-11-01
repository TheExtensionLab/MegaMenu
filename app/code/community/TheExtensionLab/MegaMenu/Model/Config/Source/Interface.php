<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

interface TheExtensionLab_MegaMenu_Model_Config_Source_Interface
{
    /**
     * Retrieve All options as an array
     * Because we use a Varien_Object for events
     *
     * @return array
     */
    public function getAllOptionsArray();
}
