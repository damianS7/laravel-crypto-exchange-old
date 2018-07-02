$(document).ready(function () {
	// Set scroll of tbody to the end
	var book_sells = document.getElementById('book_sells');
	book_sells.scrollTop = book_sells.scrollHeight;

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

// This function updates the view of the open orders of the user
// Bug 1: if orders are deleted in the server (without canceling by the user)
// orders are not removed in the panel.
function updateUserOpenOrders(data) {
	if (!Array.isArray(data) || !data.length) {
		return;
	}

	data.forEach(function (order) {
		var html = '<tr data-id="' + order.id + '">';
		html += '<td name="price"><span class="' + order.type + '-price">' + order.price + '</span></td>';
		html += '<td name="amount"><span class="amount">' + order.amount + '</span></td>';
		html += '<td name="type"><span class="' + order.type + '-price">' + order.type + '</span></td>';
		html += '<td name="date"><span>' + order.created_at + '</span></td>';
		html += '<td name="button" class="text-right"><button type="submit" data-id="' + order.id + '" class="btn btn-sm btn-danger cancel-order-button">Cancel</button></td></tr>';
		var row = $(html);
		row.hide();
		$("#table-user-orders tbody").prepend(row);
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
		$("#table-user-history tbody tr:first").prepend(row);
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

		var lastRow = $('#table-market-history > tbody > tr:last');
		lastRow.fadeOut(250, function () {
			$('#table-market-history > tbody').prepend(row);
			$(row).fadeIn('fast');
			lastRow.remove();
		});

	});

}

function getBookRow(price, amount, total) {
	rowHtml = '<tr>';
	rowHtml += '<td class="text-left" style="position:relative"><div data-amount="' + amount + '" class="bar"></div><span class="price clickable">' + price + '</span></td>';
	rowHtml += '<td class="text-center"><span class="amount clickable">' + amount + '</span></td>';
	rowHtml += '<td class="text-right"><span class="total clickable">' + total + '</span></td>';
	rowHtml += '</tr>';
	return rowHtml;
}

// This functions update/repaint the book order when new data rows
// are added.
function updateOrderBook(data) {
	if (typeof data !== 'object') {
		return;
	}

	$('#table-order-book tbody').each(function (index) {
		var tbody = $(this);
		var book = tbody.attr('id');
		var total_coins = 0; // The number of coins we count in the order book
		var mirrorBook = data;

		// The rows of the tbody
		var bodyRows = $(this).find('tr');

		// Total rows(tr) from the actual tbody
		var totalRows = bodyRows.length;

		// If the array es empty but we still have rows on the order book
		// we clear the tbody
		if (data[book].length == 0 && totalRows != 0) {
			bodyRows.remove();
		}

		//console.log('starting loop for tbody ' + book);
		// We iterate over the orders array given by the server
		for (i in data[book]) {
			// The data order from the array
			var order = data[book][i];

			// If the order book is empty we just add the first order from the array
			// as the first row so we have now rows to iterate. then we past to the next element.
			if (totalRows == 0) {
				$(this).prepend(getBookRow(order.price, order.amount, order.total));
				continue;
			}

			// Iterate over the rows
			bodyRows.each(function (rowIndex) {
				spanPrice = $(this).find('.price');
				spanAmount = $(this).find('.amount');
				bar = $(this).find('.bar');
				trPrice = spanPrice.text();
				trAmount = spanAmount.text();

				//console.log('comparing: ' + order.price + ' vs ' + trPrice);
				// if there is no row with this price in the array
				// order has been canceled so we deleted from the book
				if (typeof data[book][trPrice] === 'undefined') {
					//console.log('order not found, ' + order.price + ' removing from tbody');
					//$(this).remove();
					var deleteRow = $(this);
					$(this).fadeTo(1000, 0.05, function () {
						deleteRow.remove();
					});
				}

				// Do this when array price and tr price are equal
				if (mirrorBook[book][order.price] != '' && parseFloat(order.price) == parseFloat(trPrice)) {
					//console.log('order found in the book there is not need to continue checking again this order.');
					//data[book][order.price] = '';
					mirrorBook[book][order.price] = '';

					// If amounts are different we update the row
					if (order.amount != trAmount) {
						spanAmount.text(order.amount);
						bar.attr('data-amount', order.amount);

						// Animation for the row updated
						$(this).fadeTo(100, 0.6, function () {
							$(this).fadeTo(500, 1);
						});
					}
				}

				// Do this when we have to add a new row anywhere but at start
				if (mirrorBook[book][order.price] != '' && parseFloat(order.price) > parseFloat(trPrice)) {
					//console.log('adding ' + order.price + ' vs ' + trPrice);
					mirrorBook[book][order.price] = '';

					rowHtml = getBookRow(order.price, order.amount, order.total);
					var row = $(rowHtml);
					//row.hide();
					$(this).before(row);
					//row.fadeIn('fast');

					// Animation for the row updated
					$(this).fadeTo(100, 0.6, function () {
						$(this).fadeTo(500, 1);
					});
				}

				// Do this when we have to add a new row at start
				if (mirrorBook[book][order.price] != '' && parseFloat(order.price) < parseFloat(trPrice) && rowIndex == totalRows - 1) {
					//console.log('adding ' + order.price + ' vs ' + trPrice);
					mirrorBook[book][order.price] = '';

					rowHtml = getBookRow(order.price, order.amount, order.total);
					var row = $(rowHtml);
					//row.hide();
					$(this).after(row);
					//row.fadeIn('fast');

					// Animation for the row updated
					$(this).fadeTo(100, 0.6, function () {
						$(this).fadeTo(500, 1);
					});
				}

			});

			// We sum the coins order
			total_coins += parseFloat(order.amount);
		}
		//console.log('end loop');
		// Update the total coins at the end
		tbody.attr('data-total-coins', total_coins);
	});

	// Actual with of the table
	var tableWidth = $('#table-order-book').width();

	// Print bars
	$('#table-order-book tbody tr').each(function (index) {
		total_book_coins = $(this).closest('tbody').attr('data-total-coins');

		// The bar
		bar = $(this).find('.bar');

		// The amount of coins in the row
		trAmount = bar.attr('data-amount');
		percentOfCoins = trAmount / total_book_coins;

		// Bar width to set in pixels
		px = percentOfCoins * tableWidth;
		if (px > tableWidth) {
			px = tableWidth;
		}
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