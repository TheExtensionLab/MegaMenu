<?php

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
