const chatBox = document.getElementById('chat-box-div');

chatBox.scrollTop = chatBox.scrollHeight;

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

    message = message.trim().replace(/\s+/g, ' ');

    data = JSON.stringify({
        message,
        user_id: 5,
        chat_id: 1
    });

    $.ajax({
        url: '/api/chat',
        type: 'POST',
        data: data,
        success: (response) => {
            console.log(response);
        }
    });
});

