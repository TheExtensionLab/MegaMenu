<?php class TheExtensionLab_MegaMenu_Block_Widget_Category_Renderer extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        $html = parent::_toHtml();
        $processor = $this->_getMegaMenuHelper()->getMenuTemplateProcessor();
        $html = $processor->filter($html);
        return $html;
    }


    public function render($category,$categoryNode,$childNodes,$renderChildContent)
    {
        $this->setCategory($category);
        $this->setCategoryNode($categoryNode);
        $this->setChildNodes($childNodes);
        $this->setRenderChildContent($renderChildContent);
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

        if($template === null){
            $renderer->setTemplate('theextensionlab/megamenu/categories/list/renderer.phtml');
        }

        return $renderer;
    }

    protected function getHasDropdownContent(Varien_Data_Tree_Node $item)
    {
        $hasContent = false;

        if(!$item->hasColumns()):
            return false;
        endif;

        $columns = $item->getColumns();

        foreach($columns as $column){
            if(!empty($column['content'])):
                if($column['col_width'] != 0) {
                    $hasContent = true;
                }
            endif;
        }
        return $hasContent;
    }

    private function _getMegaMenuHelper()
    {
        return Mage::helper('theextensionlab_megamenu');
    }
}