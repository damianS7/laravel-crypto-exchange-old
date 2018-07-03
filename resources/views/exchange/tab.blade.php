<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active show" href="#tab-1" data-toggle="tab">My Orders</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#tab-2" data-toggle="tab">My History</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#tab-3" data-toggle="tab">Chat</a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active show" id="tab-1">
      @include('exchange.user_orders')
    </div>
    <div class="tab-pane" id="tab-2">
      @include('exchange.user_history')
    </div>
    <div class="tab-pane" id="tab-3">
      @include('exchange.chat')
    </div>
  </div>
</div>