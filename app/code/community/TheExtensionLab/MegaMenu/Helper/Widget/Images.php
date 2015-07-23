<?php class TheExtensionLab_MegaMenu_Helper_Widget_Images extends Mage_Cms_Helper_Wysiwyg_Images
{
    public function getImageWithPath($filename)
    {
        $fileurl = $this->getCurrentUrl() . $filename;
        $fileurl = str_replace(Mage::getBaseUrl('media'), '', $fileurl);

        return $fileurl;
    }

}