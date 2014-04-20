<?php

require(dirname(__FILE__) . '/includes/init.php');
include('includes/lib_main.php');

$_REQUEST['act'] = empty($_REQUEST['act']) ? '' : trim($_REQUEST['act']);

if ($_REQUEST['act'] == '')
{
    $admin = trim($_GET['kfgh']);
    $time = time() + 3600 * 24;

    setcookie("Callagentsn", $admin, $time, "/", "");
	$smarty->display('order_stat3.html');
}
elseif ($_REQUEST['act'] == 'top')
{

    $smarty->display('stat_top3.html');
}
elseif ($_REQUEST['act'] == 'menu')
{
    $smarty->display('drag.html');
}
elseif ($_REQUEST['act'] == 'list')
{
	//$_REQUEST['sdate'] = $_REQUEST['edate'] = date('Y-m-d');
	$list = order_list();
	
    $smarty->assign('record_count', 	$list['record_count']);
    $smarty->assign('page_count',   	$list['page_count']);
    $smarty->assign('page',       	    $list['page']);	
    $smarty->assign('pagen',       	    $list['page'] + 1);
    $smarty->assign('pagef',       	    $list['page'] - 1);
	$smarty->assign('orders',   		$list['list']);
	
	$str = '';
	foreach($list['filter'] as $key => $val)
	{
	   $str .= '&'.$key.'='.$val;
	}  
    $smarty->assign('querystr', 	$str);
	$smarty->display('order_stat_list3.html');
}

function order_list()
{
	$filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
	$filter['kfgh']     = empty($_REQUEST['kfgh'])     ? '' : trim($_REQUEST['kfgh']);
	$filter['city']     = empty($_REQUEST['city'])     ? '' : intval($_REQUEST['city']);

	$filter['sdate']    = empty($_REQUEST['sdate'])    ? '' : trim($_REQUEST['sdate']);
	$filter['edate']    = empty($_REQUEST['edate'])    ? '' : trim($_REQUEST['edate']);
	$filter['sdated']   = empty($_REQUEST['sdated'])   ? '' : trim($_REQUEST['sdated']);
	$filter['edated']   = empty($_REQUEST['edated'])   ? '' : trim($_REQUEST['edated']);
	$filter['orderman'] = empty($_REQUEST['orderman']) ? '' : trim($_REQUEST['orderman']);	
	$filter['ordertel'] = empty($_REQUEST['ordertel']) ? '' : trim($_REQUEST['ordertel']);
	$filter['consigne'] = empty($_REQUEST['consigne']) ? '' : trim($_REQUEST['consigne']);	
	$filter['contel']   = empty($_REQUEST['contel'])   ? '' : trim($_REQUEST['contel']);
	$filter['address']  = empty($_REQUEST['address'])  ? '' : trim($_REQUEST['address']);
	$filter['maddress'] = empty($_REQUEST['maddress']) ? '' : trim($_REQUEST['maddress']);
	$filter['to_buyer'] = empty($_REQUEST['to_buyer']) ? '' : trim($_REQUEST['to_buyer']);
	$filter['wsts']     = empty($_REQUEST['wsts'])     ? '' : trim($_REQUEST['wsts']);
	$filter['scts']     = empty($_REQUEST['scts'])     ? '' : trim($_REQUEST['scts']);
	$filter['pay_id']   = empty($_REQUEST['pay_id'])   ? '' : trim($_REQUEST['pay_id']);	
	
	
	$temp = array_filter($filter);

	if(empty($temp))
	{
	  $filter['kfgh'] = $_COOKIE['Callagentsn'];
	}
    $filter['status']   = $_REQUEST['status'] == ""    ? 9  : intval($_REQUEST['status']);
    $filter['ptatus']   = $_REQUEST['ptatus'] == ""    ? 9  : intval($_REQUEST['ptatus']);
    $filter['prints']   = $_REQUEST['prints'] == ""    ? 9  : intval($_REQUEST['prints']);
		
    $page     = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);	
	$filter['page_size']= $_REQUEST['page_size'] > 0 ? $_REQUEST['page_size'] : 10;	
	$where = " where 1 ";
	
	if($filter['order_sn'])
	{
	   $len = strlen($filter['order_sn']);
	   
	   $where .= $len == 4 ? " and right(b.order_id,4) = '".$filter['order_sn']."' " : " and a.order_sn = '".$filter['order_sn']."' ";
	}
	if($filter['status'] < 9)
	{
	   $where .= " and a.order_status = '".$filter['status']."' ";
	}
	if($filter['ptatus'] < 9)
	{
	   $where .= " and a.pay_status = '".$filter['ptatus']."' ";
	}
	if($filter['prints'] < 9)
	{
	   $where .= $filter['prints'] == 1 ? " and c.ptime > '0' " : " and (c.ptime = '' or c.ptime is null) ";
	}
	if($filter['city'])
	{
	   $where .= " and a.country = '".$filter['city']."' ";
	}
	if($filter['pay_id'])
	{
	   $where .= " and a.pay_id = '".$filter['pay_id']."' ";
	}
	if($filter['kfgh'])
	{
	   $where .= " and b.remark = '".$filter['kfgh']."' ";
	}

	if($filter['sdate'])
	{
		$where .= " and a.best_time >'".$filter['sdate']."' ";
	}
	if($filter['edate'])
	{
		$where .= " and LEFT(a.best_time,10) <='".$filter['edate']."' ";
	}
	if($filter['sdated'])
	{
		$where .= " and a.add_time >'".strtotime($filter['sdated'])."' ";
	}
	if($filter['edated'])
	{
		$where .= " and a.add_time <='" . (strtotime($filter['edated']) + 86400) ."' ";
	}
	if($filter['address'])
	{
	   $where .= " and a.address like '%".$filter['address']."%'";
	}
	if($filter['maddress'])
	{
	   $where .= " and a.money_address like '%".$filter['maddress']."%'";
	}
	if($filter['orderman'])
	{
	   $where .= " and a.orderman like '".$filter['orderman']."%' ";
	}
	if($filter['consigne'])
	{
	   $where .= " and a.consignee like '".$filter['consigne']."%' ";
	}
	if($filter['ordertel'])
	{
	   $where .= " and a.ordertel like '%".$filter['ordertel']."%' ";
	}
	if($filter['contel'])
	{
	   $len = strlen($filter['contel']);
	   $where .= $len == 11 ? " and a.mobile = '".$filter['contel']."' " : " and a.tel = '".$filter['contel']."' ";
	}
	if($filter['to_buyer'])
	{
	   $where .= " and a.to_buyer like '%".$filter['to_buyer']."%' ";
	}
	if($filter['scts'])
	{
	   $where .= " and a.scts like '%".$filter['scts']."%' ";
	}
	if($filter['wsts'])
	{
	   $where .= " and a.wsts like '%".$filter['wsts']."%' ";
	}	

    $sql = "SELECT COUNT(*) FROM order_genid_bak AS b left join ecs_order_info as a on a.order_id=b.order_id ".
	       "left join print_log as c on a.order_id=c.order_id ". $where;

    $record_count   = $GLOBALS['db']->getOne($sql);
    $page_count     = $record_count > 0 ? ceil($record_count / $filter['page_size']) : 1;

	$sql = "SELECT b.*,a.country,a.province,a.city,a.order_sn,a.add_time,a.best_time,a.order_status,a.pay_status,".
	       "a.order_amount,a.address,a.orderman,a.ordertel,c.ptime,c.stime FROM order_genid_bak as b ".
	       "left join ecs_order_info as a on a.order_id=b.order_id ".
		   "left join print_log as c on a.order_id=c.order_id ".$where.
	       "ORDER BY b.order_id desc".
           " LIMIT " . ($page - 1) * $filter['page_size'] . ",$filter[page_size]";
		         
	//echo $sql;
    $rs = $GLOBALS['db']->getAll($sql);
	
	foreach ($rs as $key => $val)
	{
	   $rs[$key]['i'] = $key+1;
	   $rs[$key]['add_time'] = date('Y-m-d H:i',$val['add_time']);
	   $rs[$key]['best_time'] = substr($val['best_time'],0,16);
	   $rs[$key]['orderstatus'] = $GLOBALS['os'][$val['order_status']].','.$GLOBALS['ps'][$val['pay_status']];
	   $rs[$key]['printtimes'] = $val['ptime'];
	   $rs[$key]['produceprint'] = $val['stime'];
	   $rs[$key]['address'] = rname($val['country']).rname($val['province']).rname($val['city']).$val['address'];
	}
	
    $arr = array('list' => $rs, 'filter' => $filter, 'page_count' => $page_count, 'record_count' => $record_count,'page' => $page);

    return $arr;

}

function rname($region_id)
{
	$sql = "SELECT region_name FROM ship_region WHERE region_id = '$region_id'";
	return $GLOBALS['db']->getOne($sql);
}
?>