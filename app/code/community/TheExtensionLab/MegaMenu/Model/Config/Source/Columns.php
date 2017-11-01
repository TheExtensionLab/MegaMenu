<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Config_Source_Columns
    extends TheExtensionLab_MegaMenu_Model_Config_Source_Abstract
{
    protected $_eventPrefix = 'columns';
    protected $_columnTypes = array();

    public function __construct()
    {
        $this->_columnTypes = Mage::helper('theextensionlab_megamenu/column_types')->getTypes();
    }

    public function getAllOptionsArray()
    {
        if (is_null($this->_options)) {

            $this->_options[] = array(
                'label' => Mage::helper('theextensionlab_megamenu')->__('Not Active'),
                'value' => '0'
            );

            foreach($this->_columnTypes as $columnType) {
                for ($i = 1; $i <= $columnType; $i++) {
                    $width = $this->_calculatePercentage($i,$columnType);
                    $this->_options[] = array(
                        'label' => Mage::helper('theextensionlab_megamenu')->__(
                            '%s of %s columns (%s)', $i, $columnType, $width
                        ),
                        'value' => $i . '_' . $columnType
                    );
                }
            }
        }

        return $this->_options;
    }

    private function _calculatePercentage($numerator,$denominator){
        return round(($numerator / $denominator) * 100,2) . '%';
    }
}