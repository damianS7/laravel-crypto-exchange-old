$(document).ready(function () {
	setInterval(function () {
		updateView();
	}, 1000);

	// User event when removing an open order
	$('#table-user-orders').on('click', '.cancel-order-button', function () {
		removeOrder($(this));
	});

	// User event when adding a buy order
	$('#btn-buy').on('click', function () {
		addOrder('buy');
	});

	// User event when adding a sell order
	$('#btn-sell').on('click', function () {
		addOrder('sell');
	});

	$("#order-form-container .form-control").on("change paste keyup", function () {
		var id = $(this).attr('id')
		if (id == 'input-buy-price' || id == 'input-buy-amount') {
			var price = $('#order-form-container #input-buy-price').val();
			var amount = $('#order-form-container #input-buy-amount').val();
			var result = price * amount;
			$('#order-form-container #total-buy').html(result.toFixed(8));
		} else {
			var price = $('#order-form-container #input-sell-price').val();
			var amount = $('#order-form-container #input-sell-amount').val();
			var result = price * amount;
			$('#order-form-container #total-sell').html(result.toFixed(8));
		}
	});

	$('body').on('click', '.clickable', function () {
		var text = $(this).text();
		if ($(this).hasClass('amount')) {
			$('#order-form-container #input-buy-amount').val(text);
			$('#order-form-container #input-buy-amount').change();
			$('#order-form-container #input-sell-amount').val(text);
			$('#order-form-container #input-sell-amount').change();
		}

		if ($(this).hasClass('price')) {
			$('#order-form-container #input-buy-price').val(text);
			$('#order-form-container #input-buy-price').change();
			$('#order-form-container #input-sell-price').val(text);
			$('#order-form-container #input-sell-price').change();
		}

		if ($(this).hasClass('balance')) {
			var balance = text;
			var id = $(this).attr('id')

			if (id == 'buy-balance') {
				var price = $('#order-form-container #input-buy-price').val();
				var amount = balance / price;
				$('#order-form-container #input-buy-amount').val(amount);
				$('#order-form-container #total-buy').html(text);
			}

			if (id == 'sell-balance') {
				var price = $('#order-form-container #input-sell-price').val();
				$('#order-form-container #input-sell-amount').val(balance);
				$('#order-form-container #input-sell-amount').change();
			}
		}
	});
});

// Delete an order
function removeOrder(button) {
	var payload = {
		'order_id': button.attr('data-id'),
	};

	ajax('/order/delete/', 'post', payload, function (response) {
		//console.log(response);
		if (response.status == 'ok') {
			// Remove order from user orders table
			button.closest('tr').fadeOut('fast', function () {
				button.closest('tr').remove();
			});
		} else if (response.status == 'error') {
			toastr.error('Sorry order can not be removed.');
		}
	});
}

// Adds an order (buy/sell)
function addOrder(type) {
	var payload = {
		'type': type,
		'price': $('#input-' + type + '-price').val(),
		'amount': $('#input-' + type + '-amount').val(),
		'pair_id': $('#btn-' + type).attr('data-pair'),
	};

	ajax('/order/add', 'post', payload, function (response) {
		//console.log(response);
		if (response.status == 'error') {
			toastr.error(response.message);
		} else if (response.status == 'ok') {
			toastr.success(response.message);
		}
	});
}

// User open orders
function updateUserOpenOrders(data) {
	if (!Array.isArray(data) || !data.length) {
		return;
	}

	data.forEach(function (order) {
		var html = '<tr data-id="' + order.id + '">';
		html += '<td class="text-left ' + order.type + '-price"">' + order.price + '</td>';
		html += '<td class="text-left amount">' + order.amount + '</td>';
		html += '<td class="text-left ' + order.type + '-price">' + order.type + '</td>';
		html += '<td class="text-left date">' + order.created_at + '</td>';
		html += '<td class="text-right"><button type="submit" data-id="' + order.id + '" class="btn btn-sm btn-danger cancel-order-button">Cancel</button></td>';
		html += '</tr>';
		var row = $(html);

		row.hide();
		$("#table-user-orders tbody tr:first").before(row);
		row.fadeIn('fast');
	});
}

// User filled history order
function updateUserOrderHistory(data) {
	if (!Array.isArray(data) || !data.length) {
		return;
	}

	data.forEach(function (order) {
		var html = '<tr data-id="' + order.id + '">';
		html += '<td class="text-left ' + order.type + '-price"">' + order.price + '</td>';
		html += '<td class="text-left amount">' + order.amount + '</td>';
		html += '<td class="text-left ' + order.type + '-price">' + order.type + '</td>';
		html += '<td class="text-right date">' + order.filled_at + '</td>';
		html += '</tr>';
		var row = $(html);

		row.hide();
		$("#table-user-history tbody tr:first").before(row);
		row.fadeIn('slow');
	});
}

// This only prints latest trades that are not already in the table
function updateMarketHistory(data) {
	if (!Array.isArray(data) || !data.length) {
		return;
	}
	// We add every row to the market history
	data.forEach(function (order) {
		var html = '<tr data-id="' + order.id + '">';
		html += '<td class="text-left"><span class="' + order.type + '-price clickable">' + order.price + '</span></td>';
		html += '<td class="text-left amount">' + order.amount + '</td>';
		html += '<td class="text-right date">' + order.filled_at + '</td>';
		html += '</tr>';
		var row = $(html);

		row.hide();
		$('#table-market-history > tbody > tr:first').before(row);
		row.fadeIn('slow');
	});
}


// This functions update/repaint the book order when new data rows
// are added.
function updateOrderBook(data) {
	if (typeof data !== 'object') {
		return;
	}

	// Since we have 2 tbodys we iterate over them
	$('#table-order-book tbody').each(function (tbody) {
		// The current tbody we are in
		var tbody = $(this).closest('tbody');

		// Sell orders tbody is first so it will be the one we are in
		var book = 'sell_orders';

		// When we switch to book-buys tbody we need to read buy_orders array
		if (tbody.attr('id') == 'book-buys') {
			book = 'buy_orders';
		}

		// Total rows of the current tbody
		var totalRows = $(this).find('tr').length;

		// Iteration over all rows of the tbody
		$(this).find('tr').each(function (rowIndex) {
			// We get the span tag with the price set
			var trPrice = $(this).find('.price').text();

			// We try to find an element of the array with the same price of the rom
			// this way we can update the amount and total of the rows with the same price
			if (typeof data[book][trPrice] !== 'undefined') {
				// The amount of coins in the data sent by server
				var oamount = data[book][trPrice].amount;

				// The a mount of coins in the row
				var tramount = $(this).find('.amount').text();

				// If the amounts are different, we update the row
				// with the amount sent by the server
				if (oamount != tramount) {
					$(this).find('.amount').text(oamount);
					$(this).find('.bar').attr('data-amount', oamount);
				}

				// We set the data of the array empty to ensure w
				data[book][trPrice] = '';
			} else {
				// If the price in the row its not in the array, its means
				// the order has been cancelled so we remove the row
				$(this).remove();
			}

			for (var i in data[book]) {
				if (data[book][i] != '') {
					var order = data[book][i];

					var rowHtml = '<tr>';
					rowHtml += '<td class="text-left" style="position:relative"><div data-amount="' + order.amount + '" class="bar"></div><span class="price clickable">' + order.price + '</span></td>';
					rowHtml += '<td class="text-center"><span class="amount clickable">' + order.amount + '</span></td>';
					rowHtml += '<td class="text-right"><span class="total clickable">' + order.total + '</span></td>';
					rowHtml += '</tr>';

					if (parseFloat(order.price) > parseFloat(trPrice)) {
						var row = $(rowHtml);
						row.hide();
						$(this).before(row);
						row.fadeIn('slow');
						data[book][i] = '';
					} else if (rowIndex == totalRows - 1 && parseFloat(order.price) < parseFloat(trPrice)) {
						var row = $(rowHtml);
						row.hide();
						$(this).after(row);
						row.fadeIn('slow');
						data[book][i] = '';
					}
				}
			}
		});
	});
	/*

	*/
	// Update total coins
	$('#sells-total-coins').val(data['sell_total_coins']);
	$('#buys-total-coins').val(data['buy_total_coins']);

	// Actual with of the table
	var tableWidth = $('#table-order-book').width();

	// Amount total of coins
	var totalAmountSells = $('#sells-total-coins').val();
	var totalAmountBuys = $('#buys-total-coins').val();

	// Print bars
	$('#table-order-book tbody tr').each(function (index) {
		var id = $(this).closest('tbody').attr('id');
		// The row
		var tr = this;
		// The bar
		var bar = $(tr).find('.bar');
		// The amount of coins in the row
		var trAmount = bar.attr('data-amount');
		// Calc
		if (id == 'book-sells') {
			var percentOfCoins = trAmount / totalAmountSells;
		}

		if (id == 'book-buys') {
			var percentOfCoins = trAmount / totalAmountBuys;
		}
		// Bar width to set in pixels
		var px = percentOfCoins * tableWidth;
		// Set bar width
		bar.width(px);
	});
}

function updateView() {
	var payload = {
		'last_user_orders_id': $('#table-user-orders > tbody > tr:first').attr('data-id'),
		'last_user_history_id': $('#table-user-history > tbody > tr:first').attr('data-id'),
		'last_market_history_id': $('#table-market-history > tbody > tr:first').attr('data-id'),
		'pair_id': $('#btn-sell').attr('data-pair'),
	};

	ajax('/update', 'get', payload, function (response) {
		if (response.status == 'error') {
			//console.log(response);
			return;
		}
		updateMarketHistory(response.data['market_history']);
		updateOrderBook(response.data['order_book']);
		updateUserOpenOrders(response.data['user_orders']);
		updateUserOrderHistory(response.data['user_history']);
	});
}


// Just send the data using ajax throught the specified params
// path: the route where data will be sent
// method: GET/POST
// payload: the data to send
// callback: the function to call after ajax is processed
function ajax(path, method, payload, callback) {
	payload['_token'] = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: method,
		url: '/trade/ajax' + path,
		data: payload,
		success: function (response) {
			callback(response);
		},
		error: function (response) {
			callback(response);
		}
	});
}