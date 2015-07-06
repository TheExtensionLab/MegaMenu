<?php class TheExtensionLab_MegaMenu_Model_Config_Source_List_Columns
{
    public function toOptionArray()
    {
        $maxColumns = 5;
        $options = array();
        for($i = 1;$i <= $maxColumns;$i++)
        {
            $options[] = array(
                'value' => $i,
                'label' => $i
            );
        }

        return $options;
    }
}
