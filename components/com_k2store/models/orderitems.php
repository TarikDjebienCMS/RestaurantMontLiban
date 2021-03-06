<?php
/*
 * --------------------------------------------------------------------------------
   Weblogicx India  - K2 Store v 2.4
 * --------------------------------------------------------------------------------
 * @package		Joomla! 1.5x
 * @subpackage	K2 Store
 * @author    	Weblogicx India http://www.weblogicxindia.com
 * @copyright	Copyright (c) 2010 - 2015 Weblogicx India Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link		http://weblogicxindia.com
 * --------------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once(JPATH_SITE.DS.'components'.DS.'com_k2store'.DS.'models'.DS.'_base.php' );
class K2StoreModelOrderItems extends K2StoreModelBase
{
	
    protected function _buildQueryWhere(&$query)
    {
       	$filter     	= $this->getState('filter');
       	$filter_orderid	= $this->getState('filter_orderid');
       	$filter_userid  = $this->getState('filter_userid');
       	
        $filter_productid  = $this->getState('filter_productid');
        $filter_productname  = $this->getState('filter_product_name');
        $filter_orderstates = $this->getState('filter_orderstates');
        $filter_paymentstatus = $this->getState('filter_paymentstatus') ;

        if ($filter)
       	{
			$key	= $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter ) ) ).'%');

			$where = array();
			$where[] = 'LOWER(tbl.orderitem_id) LIKE '.$key;
			$where[] = 'LOWER(tbl.orderitem_name) LIKE '.$key;
			
			$query->where('('.implode(' OR ', $where).')');
       	}

       	if ($filter_productname)
        {
            $key    = $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter_productname ) ) ).'%');
            $where = array();
            $where[] = 'LOWER(tbl.orderitem_name) LIKE '.$key;
            $query->where('('.implode(' OR ', $where).')');
        }
       
       	if ($filter_orderid)
       	{
        	$query->where('tbl.order_id = '.$this->_db->Quote($filter_orderid));
       	}

        
        if (strlen($filter_userid))
        {
            $query->where('o.user_id = '.$this->_db->Quote($filter_userid));
        }

        if (strlen($filter_productid))
        {
            $query->where('tbl.product_id = '.$this->_db->Quote($filter_productid));
        }
        
    	if (is_array($filter_orderstates) && !empty($filter_orderstates))
        {
            $query->where('tbl.order_state_id IN('.implode(",", $filter_orderstates).')' );
        }
        
    	if ( strlen($filter_paymentstatus) )
        {
            $key    = $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter_paymentstatus ) ) ).'%');
            $query->where( 'LOWER(o.transaction_status) LIKE '.$key );
        }
    }

    protected function _buildQueryFields(&$query)
    {
        $field = array();

        $field[] = " tbl.* ";
        $field[] = " p.title ";
        $field[] = " o.* ";        
        
        $query->select( $field );
    }
    
    protected function _buildQueryJoins(&$query)
    {
    	$query->join('LEFT', '#__k2_items AS p ON tbl.product_id = p.id');
        $query->join('LEFT', '#__k2store_orders AS o ON tbl.order_id = o.order_id');       
    }
    
	public function getList()
	{
		$list = parent::getList(); 
		
		// If no item in the list, return an array()
        if( empty( $list ) ){
        	return array();
        }
		
		foreach($list as $item)
		{
			$item->link = 'index.php?option=com_k2store&view=orderitems&task=edit&id='.$item->orderitem_id;
		}
		return $list;		
	}    
}
