<?php

class TheExtensionLab_MegaMenu_Model_Parser_Attribute_Option
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if(isset($params['option_ids'])) {
            $optionIds = json_decode($params['option_ids']);
            foreach($optionIds as $key => $value):
                $prefetchConfig['option_ids'][] = $key;
                if(isset($params['category_id'])):
                    $prefetchConfig['rewrite_ids'][] = 'category/'.$params['category_id'];
                endif;
            endforeach;
        }

        return $prefetchConfig;
    }
}