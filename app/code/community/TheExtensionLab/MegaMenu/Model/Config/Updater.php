<?php class TheExtensionLab_MegaMenu_Model_Config_Updater
{
    public function updateTabs(Mage_Adminhtml_Block_Widget_Tabs $tabs){
        foreach($this->_getAttributeGroupCollection() as $group){
            if($this->_isMegaMenuGroup($group)) {
                $this->_replaceTabWithErrorTab($tabs,$group);
            }
        }
    }

    private function _isMegaMenuGroup($group){
        $groupName = $group->getAttributeGroupName();
        return $groupName == "MegaMenu Settings" || $groupName == "MegaMenu Contents";
    }

    private function _replaceTabWithErrorTab($tabs,$group)
    {
        $tabs->removeTab('group_'.$group->getAttributeGroupId());
        $tabs->addTab('group_'.$group->getAttributeGroupId(), array(
            'label'     => Mage::helper('catalog')->__($group->getAttributeGroupName()),
            'content'   => $this->_getErrorMessage(),
            'active'    => true
        ));
    }

    private function _getAttributeGroupCollection()
    {
        $attributeSetId     = $this->_getCategory()->getDefaultAttributeSetId();
        return $groupCollection    = Mage::getResourceModel('eav/entity_attribute_group_collection')
            ->setAttributeSetFilter($attributeSetId)
            ->setSortOrder()
            ->load();
    }

    private function _getErrorMessage()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $errorMessage = Mage::helper('theextensionlab_megamenu')->__(
            'The Serial Key is invalid or not present and therefore the functionality of this extension has been limited. (ServerName : %s)',$serverName
        );

        return '<ul class="messages">
                    <li class="error-msg">
                        <ul>
                            <li>
                                <span>
                                    '.$errorMessage.'
                                </span>
                            </li>
                        </ul>
                    </li>
                </ul>';
    }

    private function _getCategory()
    {
        return Mage::registry('current_category');
    }

}