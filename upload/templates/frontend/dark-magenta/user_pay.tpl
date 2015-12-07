<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="visible-sm visible-xs">
				{include file='quick_jumps.tpl'}
			</div>
			<div class="hidden-sm hidden-xs">
				{include file='user_info.tpl'}
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					点卡充值
				</div>
				<div class="panel-body">

					<div class="text-warning m-b-20">
						充值续时、充值升级(强制折合成高等级时间) <br>
						•	当充值的点卡VIP等级和当前的VIP等级相同时，时间进行累计 <br>
						•	当充值的点卡VIP等级高于当前VIP等级时，自动升级到高等级VIP，并将当前VIP等级的剩余时间折合成高等级的VIP等级时间进行累计 <br>
						•	当充值的点卡VIP等级低于当前VIP等级时，不会对VIP等级进行降级，而是将新充值的低等级点卡时间折合成当前高等级的VIP等级时间累加 <br>
					</div>

					<form class="form-horizontal" name="cardPay" id="cardPay" method="post" enctype="multipart/form-data" target="_self" action="{$relative}/user/pay">
					
						<div  id="card_number" class="form-group">
							<label for="card_number" class="col-lg-3 control-label">充值卡号码</label>
							<div class="col-lg-9">
								<input name="card_number" type="text" class="form-control" value="" id="" placeholder="number" />
							</div>
						</div>
						<div  id="card_pass" class="form-group">
							<label for="card_pass" class="col-lg-3 control-label">充值卡密码</label>
							<div class="col-lg-9">
								<input name="card_pass" type="text" class="form-control" value="" id="" placeholder="pass" />
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<input name="submit_card_pay" type="submit" id="submit_card_pay" value="充值" class="btn btn-primary" />
							</div>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>
</div>