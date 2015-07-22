<?php class TheExtensionLab_MegaMenu_Model_Parser_Cms_Page_Featured
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if ($this->_hasValidCmsId($params)) {
            $prefetchConfig['cms_page_ids'][] = $params['menu_featured_cms_id'];
        }

        return $prefetchConfig;
    }

    private function _hasValidCmsId($params)
    {
        if (!isset($params['menu_featured_cms_id'])) {
            return false;
        }

        return is_numeric($params['menu_featured_cms_id']);
    }
}