<?php

namespace Excellence\Test\Block;

class Test extends \Magento\Theme\Block\Html\Header\Logo
{
   
    public function getLogoSrc()
    {
        if (empty($this->_data['logo_src'])) {
            $this->_data['logo_src'] = $this->_getLogoUrl();
        }
        return "http://webkul.com/blog/wp-content/uploads/2016/01/Magneto-Code-Snippet-2.png";
    }

   
}
