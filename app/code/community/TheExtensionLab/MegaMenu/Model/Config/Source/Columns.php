<?php

/**
 * MegaMenu Qty of Columns Attribute Source
 *
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license
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
                    $this->_options[] = array(
                        'label' => Mage::helper('theextensionlab_megamenu')->__(
                            '%s of %s columns', $i, $columnType
                        ),
                        'value' => $i . '_' . $columnType
                    );
                }
            }
        }

        return $this->_options;
    }
}