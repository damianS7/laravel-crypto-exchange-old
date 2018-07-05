$(document).ready(function () {
  // Update chat every second
  setInterval(function () {
    updateChat();
  }, 1000);

  // Enter event
  $("#chat_input").keypress(function (e) {
    if (e.which == 13) {
      send();
    }
  });
});

function updateChat() {
  var payload = {
    'last_message_id': $('#chat_view p').last().attr('data-id'),
  };



  ajax('/chat/', 'get', payload, function (response) {
    last_id = $('#chat_view p').last().attr('data-id');
    if (typeof last_id === 'undefined') {

    }

    console.log(response);
    var html = '';

    if (response.status == 'ok') {
      response.data.messages.forEach(function (message) {
        sender = message.user_id;
        date = message.created_at;
        html += '<p data-id="' + message.id + '">' + date + '(' + sender + '):' + message.message + '</p>';
      });

      $('#chat_view').append(html);

      // Set scroll of tbody to the end
      var chat_table = document.getElementById('chat_view');
      chat_table.scrollTop = chat_table.scrollHeight;
    } else if (response.status == 'error') {

    }
  });


}

// The user send a message to the chat
function send() {
  var payload = {
    'message': $('#chat_input').val(),
  };

  ajax('/chat/', 'post', payload, function (response) {
    if (response.status == 'ok') {
      $('#chat_input').val('');
    } else if (response.status == 'error') {
      toastr.error(response.message);
    }
  });
}