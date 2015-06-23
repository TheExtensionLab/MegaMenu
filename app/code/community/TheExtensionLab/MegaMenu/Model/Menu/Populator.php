<?php class TheExtensionLab_MegaMenu_Model_Menu_Populator
    extends Mage_Catalog_Model_Observer
{

    public function addCategoriesToMenu($menu, $block)
    {
        $storeCategories = $this->_getCategoryHelper()->getStoreCategories();
        $this->_addCategoriesToMenuParentNode($storeCategories, $menu, $block, true);
    }

    private function _addCategoriesToMenuParentNode($categories, $parentCategoryNode, $menuBlock, $addTags = false)
    {
        foreach ($categories as $category) {
            if (!$this->_canAddToMenu($category)) {
                continue;
            }

            $this->_addCacheTagsToModel($category, $menuBlock, $addTags); //Why?

            $categoryData = $this->_getCategoryMenuData($category);

            $categoryNode = $this->_createTreeNode($categoryData,$parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            $subcategories = $this->_getSubCategories($category);
            $this->_addCategoriesToMenuParentNode(
                $subcategories, $categoryNode, $menuBlock, $addTags
            );
        }
    }

    private function _getCategoryMenuData($category)
    {
        Mage::dispatchEvent('menu_get_category_menu_data_before', array('category' => $category));

        $nodeId = 'category-node-' . $category->getId();

        $categoryMenuData = new Varien_Object();

        $categoryMenuData->setData(array(
                'name'      => $this->_getCategoryHelper()->getMenuName($category),
                'id'        => $nodeId,
                'url'       => $this->_getCategoryUrlHelper()->getCategoryUrl($category),
                'is_active' => $this->_isActiveMenuCategory($category),
                'columns'   => $this->_getCategoryColumns($category),
                'image'     => $category->getImage(),
                'thumbnail_image' => $category->getThumbnail(),
                'menu_dropdown_width' => $category->getMenuDropdownWidth(),
                'menu_dropdown_type' => $category->getMenuDropdownType()
            )
        );

        Mage::dispatchEvent(
            'menu_get_category_menu_data_after',
            array('category' => $category, 'category_menu_data' => $categoryMenuData)
        );

        return $categoryMenuData->getData();
    }

    private function _getSubCategories($category)
    {
        $flatHelper = Mage::helper('catalog/category_flat');

        if ($flatHelper->isEnabled() && $flatHelper->isBuilt(true)) {
            $subcategories = (array)$category->getChildrenNodes();
        } else {
            $subcategories = $category->getChildren();
        }

        return $subcategories;
    }

    private function _getCategoryColumns($category)
    {
        $columns = array();
        $maxColumns = TheExtensionLab_MegaMenu_Model_Config_Source_Columns::MAX_COLUMNS;

        for ($i = 1; $i <= $maxColumns; $i++) {
            $columns['column_' . $i] = array(
                'col_width'     => $category->getData(
                    'menu_section_' . $i . '_column_width'
                ),
                'content'       => $category->getData(
                    'menu_section_' . $i . '_content'
                ),
                'column_number' => $i
            );
        }

        return $columns;
    }

    private function _createTreeNode($categoryData, $parentCategoryNode)
    {
        $tree = $parentCategoryNode->getTree();
        $categoryNode = new Varien_Data_Tree_Node($categoryData, 'id', $tree, $parentCategoryNode);

        return $categoryNode;
    }

    private function _addCacheTagsToModel($category, $menuBlock, $addTags)
    {
        $categoryModel = Mage::getModel('catalog/category');
        $categoryModel->setId($category->getId());
        if ($addTags) {
            $menuBlock->addModelTags($categoryModel);
        }
    }

    private function _canAddToMenu($category)
    {
        return ($category->getIsActive() || $category->getMenuLinkType() == 1 || $category->getMenuLinkType() == 2);
    }

    /**
     * @return TheExtensionLab_MegaMenu_Helper_Category
     */
    private function _getCategoryHelper()
    {
        return Mage::helper('theextensionlab_megamenu/category');
    }

    /**
     * @return TheExtensionLab_MegaMenu_Helper_Category_Url
     */
    private function _getCategoryUrlHelper()
    {
        return Mage::helper('theextensionlab_megamenu/category_url');
    }
}