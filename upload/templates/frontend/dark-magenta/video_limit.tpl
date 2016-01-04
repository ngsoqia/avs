{literal}
<style type="text/css">
/*弹出层的STYLE*/
body{
	height:70%;
}

.mydiv {
	background-color: #ff6;
	border: 1px solid #f90;
	text-align: center;
	line-height: 40px;
	font-size: 12px;
	font-weight: bold;
	z-index:99;
	width: 300px;
	height: 120px;
	left:50%;/*FF IE7*/
	top: 40%;/*FF IE7*/
	
	position:relative;
	
	_top:       expression(eval(document.compatMode &&
	            document.compatMode=='CSS1Compat') ?
	            documentElement.scrollTop + (document.documentElement.clientHeight-this.offsetHeight)/2 :/*IE6*/
	            document.body.scrollTop + (document.body.clientHeight - this.clientHeight)/2);/*IE5 IE5.5*/

}

</style>

{/literal}
<div id="popDiv" class="mydiv" style="display:none;">
	<span style="float:left; text-align:left; margin-left:20px; font-size: 20px; color:#F00; " >播放权限不足提示 </span><a href="{$baseurl}" style="float:right; margin-right: 20px;">X</a> <br/>
	<span style="float:left; text-align:left; margin:0px 20px; line-height:20px; color:#000; ">
		亲爱的<span style="color:#F00; ">{$showName}</span>, 您今天观看的视频已达到播放上限，无法播放该视频！
	</span><br/>
	<a href="{$baseurl}/user/pay" style="float:left; margin-left: 40px;">加入VIP</a> 
	<a href="{$baseurl}/user#sharetext" style="float:right; margin-right: 40px;">推广赚积分</a>
</div>
<div id="bg" class="bg" style="display:none;"></div>
