<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Config_Source_List_Columns
{
    public function toOptionArray()
    {
        $maxColumns = 5;
        $options = array();
        for($i = 1;$i <= $maxColumns;$i++)
        {
            $options[] = array(
                'value' => $i,
                'label' => $i
            );
        }

        return $options;
    }
}
