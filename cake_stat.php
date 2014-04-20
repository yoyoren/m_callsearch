<?php
/**
 * 蛋糕统计
 * $Author: bisc $
 * $Id: cake_stat.php 
*/

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_main.php');

$_REQUEST['act'] = empty($_REQUEST['act']) ? 'list' : trim($_REQUEST['act']);

if ($_REQUEST['act'] == 'list')
{
	$smarty->assign('ur_here',     '蛋糕统计');
    $smarty->assign('full_page',   1);
		
    $_REQUEST['bdate'] = date('Y-m-d');
	$_REQUEST['city']  = isset($_GET['city']) ? intval($_GET['city']) : 441;
	$_REQUEST['otatus']  = 1;
	
	$list = stat_list();
	
    $smarty->assign('record_count', 		$list['record_count']);
    $smarty->assign('page_count',   		$list['page_count']);
    $smarty->assign('filter',       		$list['filter']);	
	$smarty->assign('list',   		        $list['stat']);  

	$smarty->display('cake_stat.html');
}
/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $list = stat_list();

    $smarty->assign('record_count', 		$list['record_count']);
    $smarty->assign('page_count',   		$list['page_count']);
    $smarty->assign('filter',       		$list['filter']);
	$smarty->assign('list',   		        $list['stat']); 
	 
    make_json_result($smarty->fetch('cake_stat.html'), '', array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

function stat_list()
{
	$filter['bdate']  = empty($_REQUEST['bdate']) ? date('Y-m-d') : trim($_REQUEST['bdate']);
	$filter['city']   = intval($_REQUEST['city']);
	$filter['turn']   = intval($_REQUEST['turn']);
	$filter['otatus'] = intval($_REQUEST['otatus']);

	$stat = array();

	$turn = $filter['turn'] ? "AND d.turn = '".$filter['turn']."' " : '';
	$join = $filter['turn'] ? "LEFT JOIN order_dispatch AS d ON o.order_id = d.order_id " : '';
		
	$sql = "SELECT g.goods_id,g.goods_attr, sum(g.goods_number) as gsum,count(o.order_id) as osum ".
		   "FROM order_genid AS a ".
			"LEFT JOIN ecs_order_info AS o ON a.order_id = o.order_id ".
			"LEFT JOIN ecs_order_goods AS g ON o.order_id = g.order_id ".$join.
			"WHERE o.order_status = '".$filter['otatus']."' ".
			"and o.country= '". $filter['city'] ."' ".
			"AND left( o.best_time, 10 ) = '".$filter['bdate']."' ".$turn.
			"AND g.goods_price >40 group by g.goods_id,g.goods_attr ";

	$goods = $GLOBALS['db']->getAll($sql);
	foreach($goods as $key => $val)
	{
	   $stat['ch'][$key]['goods_id']   = $val['goods_id'];
	   $stat['ch'][$key]['goods_name'] = goods_name($val['goods_id']);
	   $attr = empty($val['goods_attr']) ? 0.25 : floatval($val['goods_attr']);
       $stat['ch'][$key]['goods_attr'] = $attr;
	   $stat['ch'][$key]['goods_sum']  = $val['gsum'];
	   $stat['ch'][$key]['order_sum']     = $val['osum'];

	   $stat['totalw'] += $attr * $val['gsum'];
	   $stat['totalc'] += $val['gsum'];
	   $stat['totalo'] += $val['osum'];
    }	
	

    $arr = array('stat' => $stat, 'filter' => $filter, 'page_count' => 1, 'record_count' => 1);
    return $arr;
}

function goods_name($gid)
{
   return $GLOBALS['db']->getOne("select concat(goods_sn,goods_name_style) from ecs_goods where goods_id = ".$gid);
}
?>