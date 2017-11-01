<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Model_Resource_Setup
    extends Mage_Catalog_Model_Resource_Setup
{
    const MEGAMENU_SECTIONS_COUNT_PATH = 'catalog/navigation/sections_count';

    public function addInstallationSuccessfulNotification()
    {
        if (!$this->magentoVersionHasAddNoticeMethod()) {
            return;
        }

        $docUrl = "http://docs.theextensionlab.com/mega-menu/configuration.html";
        $inboxModel = $this->_getInboxModel();
        $inboxModel->addNotice(
            'You have successfully installed TheExtensionLab_MegaMenu:
            The Menu can be configured under two new tabs for each category at Catalog > Manage categories.',
            'For full up to date documentation please see <a href="' . $docUrl . '" target="_blank">' . $docUrl . '</a>',
            'http://docs.theextensionlab.com/mega-menu/configuration.html',
            true
        );
    }

    public function magentoVersionHasAddNoticeMethod()
    {
        $inboxModel = $this->_getInboxModel();
        return method_exists($inboxModel, 'addNotice');
    }

    public function getDefaultEntities()
    {
        $menuMainAttributes = $this->_getMenuMainAttributes();
        $menuSectionsAttributes = $this->_getMenuSectionsAttributes();
        $menuProductAttributes = $this->_getMenuProductAttributes();

        $attributes = array_merge($menuMainAttributes, $menuSectionsAttributes);

        return array(
            'catalog_category' => array(
                'entity_model'                => 'catalog/category',
                'attribute_model'             => 'catalog/resource_eav_attribute',
                'table'                       => 'catalog/category',
                'additional_attribute_table'  => 'catalog/eav_attribute',
                'entity_attribute_collection' => 'catalog/category_attribute_collection',
                'attributes'                  => $attributes
            ),
            'catalog_product'  => array(
                'entity_model'                => 'catalog/product',
                'attribute_model'             => 'catalog/resource_eav_attribute',
                'table'                       => 'catalog/product',
                'additional_attribute_table'  => 'catalog/eav_attribute',
                'entity_attribute_collection' => 'catalog/product_attribute_collection',
                'attributes'                  => $menuProductAttributes
            )
        );
    }

    private function _getMenuProductAttributes()
    {
        $productAttributes = array(
            'menu_image' => array(
                'type'                    => 'varchar',
                'label'                   => 'Menu Image',
                'input'                   => 'media_image',
                'frontend'                => 'catalog/product_attribute_frontend_image',
                'required'                => false,
                'sort_order'              => 4,
                'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'used_in_product_listing' => true,
                'group'                   => 'Images',
            )
        );

        return $productAttributes;
    }

    private function _getMenuMainAttributes()
    {
        $menuMainAttributes = array(
            'menu_name'           => array(
                'type'                     => 'text',
                'label'                    => 'Menu Name',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 10,
                'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'MegaMenu Settings',
                'note'                     => 'If set this will override the default category name within the menu only.'
            ),
            'menu_dropdown_type'  => array(
                'type'       => 'int',
                'label'      => 'Menu DropDown Type',
                'input'      => 'select',
                'source'     => 'theextensionlab_megamenu/config_source_dropdown_type',
                'sort_order' => 20,
                'global'     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'group'      => 'MegaMenu Settings',
                'required'                 => false,
                'default'                    => 1
            ),
            'menu_dropdown_width' => array(
                'type'                     => 'text',
                'label'                    => 'DropDown Width',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 30,
                'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'MegaMenu Settings',
                'note'                     => 'Width of dropdown, leave empty for default width. Enter with units e.g "800px" or "80%"'
            ),
            'menu_link_type'      => array(
                'type'       => 'int',
                'label'      => 'Link Type',
                'input'      => 'select',
                'source'     => 'theextensionlab_megamenu/config_source_link_type',
                'required'   => false,
                'sort_order' => 40,
                'global'     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'group'      => 'MegaMenu Settings',
            ),
            'menu_link'           => array(
                'type'                     => 'text',
                'label'                    => 'Link',
                'input'                    => 'text',
                'required'                 => false,
                'sort_order'               => 50,
                'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'wysiwyg_enabled'          => false,
                'is_html_allowed_on_front' => false,
                'group'                    => 'MegaMenu Settings',
                'note'                     => 'Use this category as a menu link placeholder, if you set this to internal or external it is recommended you set the category "Is Active" option to no.'
            )
        );

        return $menuMainAttributes;
    }

    private function _getMenuSectionsAttributes()
    {
        $sectionsConfig = array();
        $columnsCount = (int)Mage::getConfig()->getNode(self::MEGAMENU_SECTIONS_COUNT_PATH, 'default');

        for ($i = 1; $i <= $columnsCount; $i++) {
            $sectionsConfig["menu_section_{$i}_content"] = $this->_getMenuSectionsContentAttribute($i);
            $sectionsConfig["menu_section_{$i}_column_width"] = $this->_getMenuSectionsWidthAttribute($i);
        }

        return $sectionsConfig;
    }

    private function _getMenuSectionsContentAttribute($columnNumber)
    {
        $offset = 105;
        $sortIncrement = 10;
        $sortOrder = ($sortIncrement * $columnNumber) + $offset;

        return array(
            'type'                     => 'text',
            'label'                    => "Section {$columnNumber} Content",
            'input'                    => 'textarea',
            'required'                 => false,
            'sort_order'               => $sortOrder,
            'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'wysiwyg_enabled'          => true,
            'is_html_allowed_on_front' => true,
            'group'                    => 'MegaMenu Contents'
        );
    }

    private function _getMenuSectionsWidthAttribute($columnNumber)
    {
        $offset = 100;
        $sortIncrement = 10;
        $sortOrder = ($sortIncrement * $columnNumber) + $offset;

        return array(
            'type'       => 'varchar',
            'label'      => "Section {$columnNumber} Width",
            'input'      => 'select',
            'source'     => 'theextensionlab_megamenu/config_source_columns',
            'required'   => false,
            'sort_order' => $sortOrder,
            'global'     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'group'      => 'MegaMenu Contents'
        );
    }

    private function _getInboxModel()
    {
        return Mage::getModel('adminnotification/inbox');
    }
}