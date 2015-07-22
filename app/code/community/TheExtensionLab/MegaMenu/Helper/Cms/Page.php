<?php class TheExtensionLab_MegaMenu_Helper_Cms_Page{
    public function getFullImageUrl($image)
    {
        $url = false;
        if ($image) {
            $url = Mage::getBaseUrl('media').'cms' . DS . 'menu' . DS .$image;
        }
        return $url;
    }

}