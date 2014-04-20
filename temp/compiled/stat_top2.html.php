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
<script type="text/javascript" src="js/calendar.js"></script>
<form action="order_stat2.php?act=list" method="post" target="list">
<div class="main">
城市：<select name="city"><option value="">沪杭</option>
			<option value="442">上海</option>
			<option value="440">杭州</option>
			<option value="444">苏州</option></select>
坐席：<input type="text" name="kfgh" size="6" />
订 单 号：<input type="text" name="order_sn" size="14"></td>
订单状态：<select name="status">
					<option value=""></option>
					<option value="0">未确认</option>
					<option value="1">已确认</option>
					<option value="2">已取消</option>
					<option value="3">无效</option>
					<option value="4">退货</option>
				</select>
支付状态：<select name="ptatus">
					<option value=""></option>
					<option value="0">未付</option>
					<option value="2">已付</option>
				</select>
<input type="submit" name="submit" value="开始搜索">	
</div>
<div class="hidd">
下单时间：<input type="checkbox" onpropertychange="for(i=0;i<T2.length;i++){with(T2[i]){disabled=!this.checked,style.background=!this.checked?'#ececec':'#ffffff'}}" checked>
		<input id="T2" size="10" name="sdated" type="text" readonly="true" onFocus="javascript:WdatePicker()" />　至　
		<input id="T2" size="10" name="edated" type="text" readonly="true" onFocus="javascript:WdatePicker()" />
		&nbsp;&nbsp;&nbsp;是否打印：<select name="prints">
					<option value="">全部</option>
					<option value="0">未打</option>
					<option value="1">已打</option>
				</select><br />
送货时间：<input type="checkbox" onpropertychange="for(i=0;i<T2.length;i++){with(T2[i]){disabled=!this.checked,style.background=!this.checked?'#ececec':'#ffffff'}}" checked>
		<input id="T2" size="10" name="sdate" type="text" readonly="true" onfocus="setday(this)" />　至　
		<input id="T2" size="10" name="edate" type="text" readonly="true" onfocus="setday(this)" />&nbsp;&nbsp;&nbsp;
支付方式：<select name="pay_id">
					<option value=""></option>
					<option value="1">异结</option>
					<option value="2">支付宝</option>
					<option value="3">快钱</option>
					<option value="4">到付</option>
					<option value="5">大客户</option>
					<option value="6">免费</option>
					<option value="21">银行汇款</option>
				</select>	&nbsp;&nbsp;&nbsp;大磅<input type="checkbox" name="pp" value="1" />	
				&nbsp;&nbsp;&nbsp;&nbsp;蛋糕<select name="goods_id">
				<option value="">全部</option>
				<option value="35">01-朗姆芝士</option>
				<option value="36">02-布莱克</option>
				<option value="37">03-核桃斯诺</option>
				<option value="38">04-杏仁克鲁兹</option>
				<option value="39">05-布朗尼</option>
				<option value="40">06-松仁淡奶</option>
				<option value="87">06-松仁淡奶(无糖)</option>
				<option value="41">07-栗蓉暗香</option>
				<option value="42">08-黑森林</option>
				<option value="43">09-榴莲飘飘</option>
				<option value="44">10-卡布其诺</option>
				<option value="86">10-卡布其诺(无糖)</option>
				<option value="45">11-心语心愿</option>
				<option value="46">12-百利甜情人</option>
				<option value="47">13-卡百利</option>
				<option value="48">14-花格</option>
				<option value="49">15-椰蓉可可</option>
				<option value="50">16-巧克力丝语</option>
				<option value="51">17-黑白巧克力慕斯</option>
				<option value="52">18-黑方</option>
				<option value="53">19-黑越橘</option>
				<option value="54">20-杰瑞</option>
				<option value="55">21-芒果慕斯</option>
				<option value="56">22-香橙慕斯</option>
				<option value="57">23-绿茶慕斯</option>
				<option value="58">24-提拉米苏</option>
				<option value="59">25-心脏巧克力</option>
				<option value="63">26-平安夜</option>
				<option value="64">27-爱尔兰咖啡</option>
				<option value="92">28-清境</option>
				<option value="75">29-桂圆冰淇淋蛋糕</option>
				<option value="93">30-THe Moon Cake</option>
				<option value="91">34-体验装</option>
				</select>&nbsp;&nbsp;&nbsp;磅数：
                <select name="goods_attr">
					<option value="">全部</option>
					<option value="1.0">1.0磅</option>
					<option value="2.0">2.0磅</option>
					<option value="3.0">3.0磅</option>
					<option value="5.0">5.0磅</option>
					<option value="10">10磅</option>
                    <option value="15">15磅</option>
                    <option value="20">20磅</option>
                    <option value="25">25磅</option>
                    <option value="30">30磅</option>
				</select>
		<br />
订 货 人：<input type="text" name="orderman" size="14">订货电话：<input type="text" name="ordertel" size="14">结款地址：<input type="text" name="maddress" size="14"><br />
收 货 人：<input type="text" name="consigne" size="14">收货电话：<input type="text" name="contel" size="14">送货地址：<input type="text" name="address" size="14"><br />
特殊情况：<input type="text" name="to_buyer" size="14">生产提示：<input type="text" name="scts" size="14">外送提示：<input type="text" name="wsts" size="14">

</div>
</form>
</body>
</html>
