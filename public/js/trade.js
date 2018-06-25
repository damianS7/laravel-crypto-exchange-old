$(document).ready(function () {
	setInterval(function () {
		$('#table-order-history > tbody:last-child').append('<tr><td class="text-left" style="color:#ff007a">0.00030001</td><td class="text-center" style="color:#cdcdcd">0.01000032</td><td class="text-right"style="color:#595d61">23-3-3 04:41:31</td></tr>');

		$('#table-book-buys > tbody:last-child').append('<tr class="buytext"><td class="text-left">0.00030001</td><td class="text-center" >0.01000032</td><td class="text-right">0.00003333</td></tr>');

		$('#table-book-sells > tbody:last-child').append('<tr class="selltext"><td class="text-left >0.00030001</td><td class="text-center">0.01000032</td><td class="text-right">0.00003333</td></tr>');

	}, 10000);
});

function append() {

}

function remove() {

}

function addOrder() {

}

function removeOrder() {
	$.ajax({
		type: 'DELETE',
		url: 'posts/' + id,
		data: {
			'_token': $('input[name=_token]').val(),
		},
		success: function (data) {
			toastr.success('Successfully deleted Post!', 'Success Alert', {
				timeOut: 5000
			});
			$('.item' + data['id']).remove();
		}
	});
}
/*
$('#buy-button').on('click', '.delete', function () {
});
*/
//buy
//sell
//cancel order
//append to trade history
//append to book order buy
//append to book order sell
//remove from book order buy
//remove from book order sell
//https://jmkleger.com/post/ajax-crud-for-laravel-5-4