<?php class TheExtensionLab_MegaMenu_Helper_Display_Styles
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