<?php

class TheExtensionLab_MegaMenu_Model_Parser_Url_Rewrite
    implements TheExtensionLab_MegaMenu_Model_Parser_Interface
{
    public function parse($params)
    {
        $prefetchConfig = array();
        if(isset($params['option_ids']) && isset($params['category_id'])) {
            $optionIds = json_decode($params['option_ids']);
            foreach($optionIds as $key => $value):
                $prefetchConfig['rewrite_ids'][] = 'category/'.$params['category_id'];
            endforeach;
        }

        return $prefetchConfig;
    }
}