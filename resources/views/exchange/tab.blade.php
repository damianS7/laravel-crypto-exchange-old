<div class="tabbable" id="tabs-932074">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active show" href="#panel-198955" data-toggle="tab">My Orders</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#panel-798248" data-toggle="tab">My History</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active show" id="panel-198955">
			@include('exchange.userOrders')
		</div>
		<div class="tab-pane" id="panel-798248">
			@include('exchange.userHistory')
		</div>
	</div>
</div>
