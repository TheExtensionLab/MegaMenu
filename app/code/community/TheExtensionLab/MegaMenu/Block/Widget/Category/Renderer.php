<?php class TheExtensionLab_MegaMenu_Block_Widget_Category_Renderer extends Mage_Core_Block_Template
{
    public function render($category,$categoryNode,$childNodes)
    {
        $this->setCategory($category);
        $this->setCategoryNode($categoryNode);
        $this->setChildNodes($childNodes);
        return $this->toHtml();
    }

    protected function _getCustomCategoryMenuName($categoryNode, $categoryJson)
    {
        if(isset($categoryJson->custom_name)){
            return $categoryJson->custom_name;
        }

        return $categoryNode->getName();
    }

    protected function _getCategoryRenderer($template = null)
    {
        $renderer = $this->getLayout()->createBlock('theextensionlab_megamenu/widget_category_renderer');

        if($template === null) {
            $renderer->setTemplate('theextensionlab/megamenu/categories/list/renderer.phtml');
        }

        return $renderer;
    }
}