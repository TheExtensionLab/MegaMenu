<?php class TheExtensionLab_MegaMenu_Helper_Protector
    extends Mage_Core_Helper_Abstract
{
    protected $_extensionCode = "TheExtensionLab_MegaMenu";

    public function checkExtension()
    {
        if (Mage::getStoreConfig('catalog/navigation/checked')) {
            return true;
        }

        $serverName = $_SERVER['SERVER_NAME'];
        $serverName = $this->_stripSubdomainsFromServerName($serverName);

        if ($this->_checkServerName($serverName)) {
            Mage::getConfig()->saveConfig('catalog/navigation/checked', 1);
            return true;
        }

        return false;

    }

    private function _stripSubdomainsFromServerName($serverName)
    {
        $parts = explode( '.', $serverName );
        $slicedArray = array_slice( $parts, -2, 1 );
        $slice = ( strlen( reset( $slicedArray ) ) == 2 ) && ( count( $parts ) > 2 ) ? 3 : 2;
        return implode( '.', array_slice( $parts, ( 0 - $slice ), $slice ) );
    }

    private function _checkServerName($serverName)
    {
        $string = hash('sha256', $this->_extensionCode . $serverName);
        $configValue = Mage::getStoreConfig('catalog/navigation/protected');

        if ($string == trim($configValue)) {
            return true;
        }

        return false;
    }
}