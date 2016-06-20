<?php
namespace Excellence\Slider\Model\ResourceModel;
class Sliderpages extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('excellence_slider_sliderpages','id');
    }
    public function getSliderId($pageTypeId, $currentPageId, $position)
    {
    	$table = $this->getMainTable();
        $whereTypeId = $this->getConnection()->quoteInto("slider_display_page = ?", $pageTypeId);
        if($pageTypeId == 1){
            $wherePageId = $this->getConnection()->quoteInto("slider_specific_display_page_cms = ?", $currentPageId);
        }
        else if($pageTypeId == 2){
            $wherePageId = $this->getConnection()->quoteInto("slider_specific_display_page_category = ?", $currentPageId);
        }
        else if($pageTypeId == 3){
            $wherePageId = $this->getConnection()->quoteInto("slider_specific_display_page_product = ?", $currentPageId);
        }
        else{
            $wherePageId = null;
        }
        if($wherePageId != null){
            $wherePosition = $this->getConnection()->quoteInto("slider_position = ?", $position);
            $whereStatus = $this->getConnection()->quoteInto("is_active = ?", 1);
            $sql = $this->getConnection()->select()
                        ->from($table,array('id'))
                        ->where($whereTypeId)
                        ->where($wherePageId)
                        ->where($wherePosition)
                        ->where($whereStatus);
        } else{
            $wherePosition = $this->getConnection()->quoteInto("slider_position = ?", $position);
            $whereStatus = $this->getConnection()->quoteInto("is_active = ?", 1);
            $sql = $this->getConnection()->select()
                        ->from($table,array('id'))
                        ->where($whereTypeId)
                        ->where($wherePosition)
                        ->where($whereStatus);
        }
        $id = $this->getConnection()->fetchOne($sql);
        return $id;
    }
}
