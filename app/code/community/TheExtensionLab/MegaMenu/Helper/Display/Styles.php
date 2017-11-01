<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Helper_Display_Styles
{
    public function getDisplayClass(array $screensToDisplayOn)
    {
        $displayClasses = array();

        $screenTypes = array(
            'small',
            'medium',
            'large'
        );

        foreach($screenTypes as $screenType){
            if(!in_array($screenType,$screensToDisplayOn)){
                $displayClasses[] = 'hide-on-'.$screenType;
            }
        }

        $displayCssClasses = implode(' ',$displayClasses);

        return $displayCssClasses;
    }
}