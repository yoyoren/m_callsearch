<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单搜索</title>
<style>
body{color:#CC0033;font-size:12px;}
td{font-size:12px;color:#000000}
input{border:#CCCCCC 1px solid;}
a:hover{color:#CC0000;}
a:visited{color:#800080;text-decoration:underline;}
.top{background-color:#FFFFCC;height:35px;}
.main{border:#CCCCCC 0px solid;height:350px;}
.resizeDivClass{position:relative;background-color:red;width:2px;z-index:1;left:expression(this.parentElement.offsetWidth-1);cursor:e-resize;}
</style>
</head>
<script language=javascript>
function MouseDownToResize(obj){
obj.mouseDownX=event.clientX;
obj.pareneTdW=obj.parentElement.offsetWidth;
obj.pareneTableW=theObjTable.offsetWidth;
obj.setCapture();
}
function MouseMoveToResize(obj){
    if(!obj.mouseDownX) return false;
    var newWidth=obj.pareneTdW*1+event.clientX*1-obj.mouseDownX;
    if(newWidth>0)
    {
obj.parentElement.style.width = newWidth;
theObjTable.style.width=obj.pareneTableW*1+event.clientX*1-obj.mouseDownX;
}
}
function MouseUpToResize(obj){
obj.releaseCapture();
obj.mouseDownX=0;
}
</script>
</head>
<body class="top">
<div class="main">
	<table id=theObjTable STYLE="table-layout:fixed" cellspacing=1 cellpadding=1 bgcolor=#bab196 border=0>
		<tr bgcolor=#CCCCFF>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width="30">
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				详情
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=90>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				订单状态
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=50>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				配送打印
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=40>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				生产打印
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=40>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				序号
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=100>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				订单号
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=120>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				送货时间
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=30>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				磅重
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=350>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				送货地址
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=100>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				订货人
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=100>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				电话
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=40>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				应收
			</td>
						<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=40>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				坐席
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width=120>
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				下单时间
			</td>
			<td valign=top style="overflow: hidden; text-overflow:ellipsis" width="30">
				<font class="resizeDivClass" onmousedown="MouseDownToResize(this);" onmousemove="MouseMoveToResize(this);" onmouseup="MouseUpToResize(this);"></font>
				详情
			</td>
		</tr>
		<?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
			<tr bgcolor=#FFFFFF onMouseOver="this.style.backgroundColor='#FFCCCC'" onMouseOut="this.style.backgroundColor=''">
				<td align=center width="30" bgcolor=#FFFF66><a href='http://192.168.2.103/call/order.php?act=detail&order_id=<?php echo $this->_var['list']['order_id']; ?>' target='_blank'>详情</a></td>
				<td bgcolor=#FFFF66><?php echo $this->_var['list']['orderstatus']; ?></td>
				<td align=center bgcolor=#FFFF66><?php if ($this->_var['list']['printtimes'] > '0'): ?><font color=#FF0000>已打</font><?php else: ?><font color=#33CC00>未打</font><?php endif; ?></td>
				<td align=center bgcolor=#FFFF66><?php if ($this->_var['list']['produceprint'] > '0'): ?><font color=#FF0000>已打</font><?php else: ?><font color=#33CC00>未打</font><?php endif; ?></td>
				<td align=center><?php echo $this->_var['list']['i']; ?></td>
				<td><?php echo $this->_var['list']['order_sn']; ?></td>
				<td><?php echo $this->_var['list']['best_time']; ?></td>
				<td><?php echo $this->_var['list']['goods_attr']; ?></td>
				<td><?php echo $this->_var['list']['address']; ?></td>
				<td><?php if ($this->_var['list']['ordertel']): ?><?php echo $this->_var['list']['orderman']; ?><?php else: ?><?php echo $this->_var['list']['consignee']; ?><?php endif; ?></td>
				<td><?php if ($this->_var['list']['ordertel']): ?><?php echo $this->_var['list']['ordertel']; ?><?php else: ?><?php echo $this->_var['list']['mobile']; ?><?php endif; ?></td>
				<td><?php echo $this->_var['list']['order_amount']; ?></td>
				<td><?php echo empty($this->_var['list']['remark']) ? '9999' : $this->_var['list']['remark']; ?></td>
				<td><?php echo $this->_var['list']['add_time']; ?></td>
				<td align=center width="30" bgcolor=#FFFF66><a href='http://192.168.2.103/call/order.php?act=show&order_id=<?php echo $this->_var['list']['order_id']; ?>' target="_blank">详情</a></td>
			</tr>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</table>
	<table><tr><td>共计 <span id="totalRecords"><?php echo $this->_var['record_count']; ?></span>
        条记录，共有 <span id="totalPages"><?php echo $this->_var['page_count']; ?></span>
        页，当前第 <span id="pageCurrent"><?php echo $this->_var['page']; ?></span>
        页，每页10条，
        <span id="page-link">
          <a href="order_stat2.php?act=list&page=1<?php echo $this->_var['querystr']; ?>">第一页</a>
          <a href="order_stat2.php?act=list&page=<?php echo $this->_var['pagef']; ?><?php echo $this->_var['querystr']; ?>">上一页</a>
          <a href="order_stat2.php?act=list&page=<?php echo $this->_var['pagen']; ?><?php echo $this->_var['querystr']; ?>">下一页</a>
          <a href="order_stat2.php?act=list&page=<?php echo $this->_var['page_count']; ?><?php echo $this->_var['querystr']; ?>">最末页</a>
        </span></td></tr></table>
</div>
</body>
</html>
