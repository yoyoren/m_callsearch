<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style>
body{color:#CC0033;font-size:12px;}
td{font-size:12px;}
input{border:#CCCCCC 1px solid;}
.top{background-color:#FFFFCC;line-height:30px;margin-top:2px;}
.main{border:#CCCCCC 1px solid;height:30px;}
.hidd{border:#CCCCCC 1px solid;height:150px;}
</style>
</head>
<body class="top">
<?php echo $this->smarty_insert_scripts(array('files'=>'datepicker/WdatePicker.js')); ?>
<form action="order_bstat.php?act=list" method="post" target="list">
<div class="main">
选择城市：<select name="city"><option value="">全部</option>
			<option value="441">北京</option>
			</select>
坐席：<input type="text" name="kfgh" size="6" />
订 单 号：<input type="text" name="order_sn" size="14"></td>
订单状态：<select name="status">
					<option value=""></option>
					<option value=0>未确认</option>
					<option value=1>已确认</option>
					<option value=2>已取消</option>
					<option value=3>无效</option>
					<option value=4>退货</option>
				</select>
支付状态：<select name="ptatus">
					<option value=""></option>
					<option value=0>未付</option>
					<option value=2>已付</option>
				</select>
<input type="submit" name="submit" value="开始搜索">	
</div>
<div class="hidd">
下单时间：<input type="checkbox" onpropertychange="for(i=0;i<T2.length;i++){with(T2[i]){disabled=!this.checked,style.background=!this.checked?'#ececec':'#ffffff'}}" checked>
		<input id="T2" size="10" name="sdated" type="text" readonly="true" onFocus="javascript:WdatePicker()" />　至　
		<input id="T2" size="10" name="edated" type="text" readonly="true" onFocus="javascript:WdatePicker()" />&nbsp;&nbsp;&nbsp;&nbsp;
		是否打印：<select name="prints">
					<option value="">全部</option>
					<option value="0">未打</option>
					<option value="1">已打</option>
				</select><br />
送货时间：<input type="checkbox" onpropertychange="for(i=0;i<T2.length;i++){with(T2[i]){disabled=!this.checked,style.background=!this.checked?'#ececec':'#ffffff'}}" checked>
		<input id="T2" size="10" name="sdate" type="text" readonly="true" onFocus="javascript:WdatePicker()" />　至　
		<input id="T2" size="10" name="edate" type="text" readonly="true" onFocus="javascript:WdatePicker()" />&nbsp;&nbsp;&nbsp;&nbsp;
支付方式：<select name="pay_id">
					<option value=""></option>
					<option value=1>异结</option>
					<option value=2>支付宝</option>
					<option value=3>快钱</option>
					<option value=4>到付</option>
					<option value=5>大客户</option>
					<option value=6>免费</option>
					<option value=21>银行汇款</option>
				</select>		
		<br />
订 货 人：<input type="text" name="orderman" size="14">订货电话：<input type="text" name="ordertel" size="14">结款地址：<input type="text" name="maddress" size="14"><br />
收 货 人：<input type="text" name="consigne" size="14">收货电话：<input type="text" name="contel" size="14">送货地址：<input type="text" name="address" size="14"><br />
特殊情况：<input type="text" name="to_buyer" size="14">生产提示：<input type="text" name="scts" size="14">外送提示：<input type="text" name="wsts" size="14">

</div>
</form>
</body>
</html>
