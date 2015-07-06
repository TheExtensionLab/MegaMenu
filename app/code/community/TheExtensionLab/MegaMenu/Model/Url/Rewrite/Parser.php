<?php

class TheExtensionLab_MegaMenu_Model_Url_Rewrite_Parser
    implements TheExtensionLab_MegaMenu_Model_Widget_Parser_Interface
{
    public function saveDataToPrefetch($params)
    {
        $dataToPrefetch = array();
        if(isset($params['option_ids']) && isset($params['category_id'])) {
            $optionIds = json_decode($params['option_ids']);
            foreach($optionIds as $key => $value):
                    $dataToPrefetch['rewrite_ids'][] = 'category/'.$params['category_id'];
            endforeach;
        }

        return $dataToPrefetch;
    }
}