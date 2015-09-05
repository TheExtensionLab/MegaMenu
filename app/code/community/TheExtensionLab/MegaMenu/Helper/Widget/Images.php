<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Helper_Widget_Images extends Mage_Cms_Helper_Wysiwyg_Images
{
    public function getImageWithPath($filename)
    {
        $fileurl = $this->getCurrentUrl() . $filename;
        $fileurl = str_replace(Mage::getBaseUrl('media'), '', $fileurl);

        return $fileurl;
    }

}