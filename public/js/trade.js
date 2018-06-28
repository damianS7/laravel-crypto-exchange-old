$(document).ready(function () {
	setInterval(function () {
		//updateBook();
		updateMarketHistory();
		updateOrders();
		updateFilled();
	}, 1000);

	// User event when removing an open order
	$('.cancel-order-button').on('click', function () {
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
			button.closest('tr').fadeOut('slow', function () {
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
		'pair': $('#btn-' + type).attr('data-pair'),
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
function updateOrders() {
	var payload = {
		'last_id': $('#table-user-orders > tbody > tr:first').attr('data-id'),
		'pair_id': $('#btn-buy').attr('data-pair')
	};

	// Bug duplicated data
	ajax('/order/open', 'get', payload, function (response) {
		//console.log(response);
		response.data.forEach(function (order) {
			var html = '<tr data-id="' + order.id + '">';
			html += '<td class="text-left ' + order.type + '-price"">' + order.price + '</td>';
			html += '<td class="text-left amount">' + order.amount + '</td>';
			html += '<td class="text-left ' + order.type + '-price">' + order.type + '</td>';
			html += '<td class="text-right date">' + order.created_at + '</td>';
			html += '<td class="text-right"><button type="submit" data-id="' + order.id + '" class="btn btn-sm btn-danger cancel-order-button">Delete</button></td>';
			html += '</tr>';
			var row = $(html);

			row.hide();
			$("#user-orders > table tr:first").before(row);
			row.fadeIn('slow');
		});
	});
}

// User filled history order
function updateFilled() {
	var payload = {
		'last_id': $('#table-user-history > tbody > tr:first').attr('data-id'),
		'pair_id': $('#btn-buy').attr('data-pair')
	};

	// Bug duplicated data
	ajax('/order/filled', 'get', payload, function (response) {
		//console.log(response);
		response.data.forEach(function (order) {
			var html = '<tr data-id="' + order.id + '">';
			html += '<td class="text-left ' + order.type + '-price"">' + order.price + '</td>';
			html += '<td class="text-left amount">' + order.amount + '</td>';
			html += '<td class="text-left ' + order.type + '-price">' + order.type + '</td>';
			html += '<td class="text-right date">' + order.filled_at + '</td>';
			html += '</tr>';
			var row = $(html);

			row.hide();
			$("#user-history > table tr:first").before(row);
			row.fadeIn('slow');
		});
	});
}

// This only prints latest trades that are not already in the table
function updateMarketHistory() {
	var payload = {
		'last_id': $('#table-market-history > tbody > tr:first').attr('data-id'),
		'pair_id': $('#btn-sell').attr('data-pair'),
	};

	ajax('/order/history', 'get', payload, function (response) {
		//console.log(response);
		if (response.data) {
			// We add every row to the market history
			response.data.forEach(function (order) {
				var html = '<tr data-id="' + order.id + '">';
				html += '<td class="text-left ' + order.type + '-price"">' + order.price + '</td>';
				html += '<td class="text-left amount">' + order.amount + '</td>';
				html += '<td class="text-right date">' + order.filled_at + '</td>';
				html += '</tr>';
				var row = $(html);

				row.hide();
				$('#table-market-history > tbody > tr:first').before(row);
				row.fadeIn('slow');
			});
		}
	});
}


// This functions update/repaint the book order when new data rows
// are added.
function updateBook() {
	var payload = {
		'last_id': $('#table-trade-history > tbody > tr:first').attr('data-id'),
		'pair_id': $('#btn-sell').attr('data-pair'),
	};

	ajax('/order/book', 'get', payload, function (response) {
		//console.log(response);
		if (response.data) {
			// We add every row to the market history
			response.data.forEach(function (row) {

			});
		}
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