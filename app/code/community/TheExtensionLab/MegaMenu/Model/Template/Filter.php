<?php class TheExtensionLab_MegaMenu_Model_Template_Filter extends Mage_Widget_Model_Template_Filter
{

    /**
     * Changed function so that each loop can log an exception rather than just throwing it back again
     * Old way if there was one error in the menu the whole thing would disappear - this way only the section with
     * an error is removed.
     */
    public function filter($value)
    {
            try {
                // "depend" and "if" operands should be first
                foreach (array(
                    self::CONSTRUCTION_DEPEND_PATTERN => 'dependDirective',
                    self::CONSTRUCTION_IF_PATTERN     => 'ifDirective',
                ) as $pattern => $directive) {
                    if (preg_match_all($pattern, $value, $constructions, PREG_SET_ORDER)) {
                        foreach($constructions as $index => $construction) {
                            $replacedValue = '';
                            $callback = array($this, $directive);
                            if(!is_callable($callback)) {
                                continue;
                            }
                            try {
                                $replacedValue = call_user_func($callback, $construction);
                            } catch (Exception $e) {
                                Mage::logException($e);
                            }
                            $value = str_replace($construction[0], $replacedValue, $value);
                        }
                    }
                }

                if(preg_match_all(self::CONSTRUCTION_PATTERN, $value, $constructions, PREG_SET_ORDER)) {
                    foreach($constructions as $index=>$construction) {
                        $replacedValue = '';
                        $callback = array($this, $construction[1].'Directive');
                        if(!is_callable($callback)) {
                            continue;
                        }
                        try {
                            $replacedValue = call_user_func($callback, $construction);
                        } catch (Exception $e) {
                            Mage::logException($e);
                        }
                        $value = str_replace($construction[0], $replacedValue, $value);
                    }
                }
                return $value;
            } catch (Exception $e) {
                $value = '';
                Mage::logException($e);
            }
        return $value;
    }
}