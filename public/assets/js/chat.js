const chatBox = document.getElementById('chat-box-div');

chatBox.scrollTop = chatBox.scrollHeight;

let socket = io.connect('http://localhost:3000');

$(document).ready(() => {
    socket.emit('join', { userId: $('#myId').val() });
});

socket.on('chat', function (data) {
    console.log(data);
});

$('#chatForm').on('submit', (e) => {
    e.preventDefault();

    let message = $('#messageBox').val();

    $('#messageBox').removeClass('is-invalid');
    $('#messageBoxError').html('');

    if (message.trim() === '') {
        $('#messageBox').addClass('is-invalid');
        $('#messageBoxError').html('Message cannot be empty');
        return;
    }
    $('#message-input').val('');
    message = message.trim().replace(/\s+/g, ' ');

    $.ajax({
        url: '/api/chat',
        type: 'POST',
        data: JSON.stringify({
            message,
            from: parseInt($('#myId').val()),
            to: parseInt($('#myId').val()) == 4 ? 1 : 4
        }),
        success: (response) => {
            console.log(response);
        }
    });


});

