const chatBox = document.getElementById('chat-box-div');
chatBox.scrollTop = chatBox.scrollHeight;

let socket = io.connect('http://localhost:3000');
let userID = parseInt($('#myId').val());
let room = window.location.pathname.split('/').pop();

$.ajax({
    url: `/api/chat/join/${room}`,
    type: 'POST',
    success: (response) => {
        socket.emit('join', { socketKey: response.socketKey });

        response.messages.forEach((data) => {
            appendMessage(data);
        });

        chatBox.scrollTop = chatBox.scrollHeight;
    },
    error: (error) => {
        console.log(error.responseJSON);
    },
});

socket.on('read chat', (data) => {
    appendMessage(data);
    chatBox.scrollTop = chatBox.scrollHeight;
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


    message = message.trim();

    $('#messageBox').val('');

    $.ajax({
        url: `/api/chat/${room}`,
        type: 'POST',
        data: JSON.stringify({
            message,
        }),
        success: (response) => {

        },
        error: (error) => {
            $('#messageBox').addClass('is-invalid');
            $('#messageBoxError').html(error.responseJSON.errors.message[0] || 'An error occurred');
        },
    });
});

/**
 * Append message to chat box
 * 
 * @param {*} data  Object containing message data
 */
function appendMessage(data) {
    $(`
<li class="d-flex justify-content-between mb-4">
    ${data.senderId === userID ? '' : `<img src="/${data.senderPfp}" alt="avatar" class="rounded-circle d-flex align-self-start m-2 shadow-1-strong" width="50">`}
    <div class="card w-100">
        <div class="card-header d-flex justify-content-between p-3">
            <p class="fw-bold mb-0">${data.senderName}</p>
            <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${data.timestamp} </p>
        </div>
        <div class="card-body">
            <p class="mb-0">
                ${data.content}
            </p>
        </div>
    </div>
    ${data.senderId !== userID ? '' : `<img src="/${data.senderPfp}" alt="avatar" class="rounded-circle d-flex align-self-start m-2 shadow-1-strong" width="50px">`}
</li>
    `).insertBefore($('#chat-box-div form'));
}