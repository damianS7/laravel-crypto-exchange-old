$(document).ready(function () {
  // Set scroll of tbody to the end
  var book_sells = document.getElementById('book_sells');
  book_sells.scrollTop = book_sells.scrollHeight;

  setInterval(function () {
    updateView();
  }, 1000);
  // Select first tab on markets when load
  $('.nav-tabs .nav-item a').first().addClass('active show');
  $('.tab-pane').first().addClass('active show');

  $('#market_menu_tabs').on('keyup', '#search_coin', function () {
    searchFilter();
  });
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

function searchFilter() {
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("search_coin");
  filter = input.value.toUpperCase();
  //table = $('.tab-pane.active.show > table');//document.getElementById("myTable");
  table = document.querySelector(".tab-pane.active.show>table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      tdText = td.querySelector("a").innerHTML;
      if (tdText.toUpperCase().startsWith(filter)) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

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
    'market_id': $('#btn-' + type).attr('data-market'),
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

  html = '';
  data.forEach(function (order) {
    html += '<tr data-id="' + order.id + '">';
    html += '<td name="price"><span class="' + order.type + '-price">' + order.price + '</span></td>';
    html += '<td name="amount"><span class="amount">' + order.amount + '</span></td>';
    html += '<td name="type"><span class="' + order.type + '-price">' + order.type + '</span></td>';
    html += '<td name="date"><span>' + order.created_at + '</span></td>';
    html += '<td name="button" class="text-right"><button type="submit" data-id="' + order.id + '" class="btn btn-sm btn-danger cancel-order-button">Cancel</button></td></tr>';
  });

  tbody = $('#table-user-orders tbody');
  maxRows = 100;
  totalRows = tbody.find('tr').length;

  if (html != '') {
    html = $(html);
    html.hide();
    tbody.prepend(html);
    html.fadeIn('slow');
  }

  if (totalRows > maxRows) {
    var rows = tbody.find('tr').slice(maxRows - totalRows);
    rows.fadeOut('fast', function () {
      rows.remove();
    });
  }
}

// User filled history order
function updateUserOrderHistory(data) {
  if (!Array.isArray(data) || !data.length) {
    return;
  }

  html = '';
  data.forEach(function (order) {
    html += '<tr data-id="' + order.id + '">';
    html += '<td name="price""><span class="' + order.type + '-price">' + order.price + '</span></td>';
    html += '<td name="amount"><span class="amount">' + order.amount + '</span></td>';
    html += '<td name="type"><span class="' + order.type + '-price">' + order.type + '</span></td>';
    html += '<td name="date" class="text-right"><span class="date">' + order.filled_at + '</span></td>';
    html += '</tr>';
  });

  tbody = $('#table-user-history tbody');
  maxRows = 10;
  totalRows = tbody.find('tr').length;

  if (html != '') {
    html = $(html);
    html.hide();
    tbody.prepend(html);
    html.fadeIn('slow');
  }

  if (totalRows > maxRows) {
    var rows = tbody.find('tr').slice(maxRows - totalRows);
    rows.fadeOut('fast', function () {
      rows.remove();
    });
  }
}

// This only prints latest trades that are not already in the table
function updateMarketHistory(data) {
  if (!Array.isArray(data) || !data.length) {
    return;
  }
  html = '';
  tbody = $('#table-market-history > tbody');
  maxRows = 100;
  totalRows = tbody.find('tr').length;

  // We add every row to the market history
  data.forEach(function (order) {
    html += '<tr data-id="' + order.id + '">';
    html += '<td class="text-left"><span class="' + order.type + '-price clickable">' + order.price + '</span></td>';
    html += '<td class="text-left amount">' + order.amount + '</td>';
    html += '<td class="text-right date">' + order.filled_at + '</td>';
    html += '</tr>';
  });

  if (html != '') {
    html = $(html);
    html.hide();
    tbody.prepend(html);
    html.fadeIn('slow');
  }

  if (totalRows > maxRows) {
    var rows = tbody.find('tr').slice(maxRows - totalRows);
    rows.fadeOut('fast', function () {
      rows.remove();
    });
  }
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

  // Bug row duplicated on mass add
  $('#table-order-book tbody').each(function (index) {
    var book = $(this).attr('data-key-name');

    // If the array is empty there is nothing to do ...
    if (data[book].length == 0) {
      $(this).empty();
      return true;
    }

    var total_coins = 0; // The number of coins we count in the order book

    // We iterate over the orders array given by the server
    for (i in data[book]) {
      // The data order from the array
      var order = data[book][i];

      // If array price is empty we pass to the next element
      if (data[book][order.price] == '') {
        continue;
      }

      // Total rows(tr) from the actual tbody
      var totalRows = $(this).find('tr').length;

      // If the order book is empty we just add the first order from the array
      // as the first row so we have now rows to iterate. then we past to the next element.
      if (totalRows == 0) {
        data[book][order.price] = '';
        $(this).prepend(getBookRow(order.price, order.amount, order.total));
        continue;
      }

      // Iterate over the rows
      $(this).find('tr').each(function (rowIndex) {
        spanAmount = $(this).find('.amount');
        spanPrice = $(this).find('.price');
        trAmount = spanAmount.text();
        trPrice = spanPrice.text();
        bar = $(this).find('.bar');

        // if there is no row with this price in the array
        // order has been canceled so we deleted from the book
        if (typeof data[book][trPrice] === 'undefined') {
          $(this).remove();
          return true;
        }

        // Do this when array price and tr price are equal
        if (data[book][order.price] != '' && parseFloat(order.price) == parseFloat(trPrice)) {
          data[book][order.price] = '';

          // If amounts are different we update the row
          if (order.amount != trAmount) {
            spanAmount.text(order.amount);
            $(this).find('.total').text(order.total);
            bar.attr('data-amount', order.amount);
          }
        }

        // Do this when we have to add a new row anywhere but at start
        if (data[book][order.price] != '' && parseFloat(order.price) > parseFloat(trPrice)) {
          data[book][order.price] = '';
          rowHtml = getBookRow(order.price, order.amount, order.total);
          var row = $(rowHtml);
          row.hide();
          $(this).before(row);
          row.fadeIn('fast');
        }

        // Do this when we have to add a new row at start
        if (data[book][order.price] != '' && parseFloat(order.price) < parseFloat(trPrice) && rowIndex == totalRows - 1) {
          data[book][order.price] = '';
          rowHtml = getBookRow(order.price, order.amount, order.total);
          var row = $(rowHtml);
          row.hide();
          $(this).after(row);
          row.fadeIn('fast');
        }
      });

      // We sum the coins order
      total_coins += parseFloat(order.amount);
    }
    // Update the total coins at the end
    $(this).attr('data-total-coins', total_coins);
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
    'market_id': $('#btn-sell').attr('data-market'),
  };

  ajax('/update', 'get', payload, function (response) {
    if (response.status == 'error') {
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