const chatBox = document.getElementById('chat-box-div');
chatBox.scrollTop = chatBox.scrollHeight;

let socket = io.connect('http://localhost:3000');
let userID = parseInt($('#myId').val());
let room = window.location.pathname.split('/').pop();

socket.emit('join', { room, userID });

socket.on('read chat', (data) => {
    console.log(data);
    appendMessage(data);
    chatBox.scrollTop = chatBox.scrollHeight;
});

$('#chatForm').on('submit', (e) => {
    e.preventDefault();

    let message = $('#messageBox').val();

    $('#messageBox').removeClass('is-invalid');
    $('#messageBoxError').html('');
    /*
        if (message.trim() === '') {
            $('#messageBox').addClass('is-invalid');
            $('#messageBoxError').html('Message cannot be empty');
            return;
        }
        $('#message-input').val('');
        message = message.trim().replace(/\s+/g, ' ');
    
        $('#messageBox').val('');*/

    $.ajax({
        url: `/api/chat/${room}`,
        type: 'POST',
        data: JSON.stringify({
            message,
            from: userID,
        }),
        success: (response) => {
        },
        error: (error) => {
            $('#messageBox').addClass('is-invalid');
            $('#messageBoxError').html(error.responseJSON.errors.message[0] || 'An error occurred');
        },
    });
});

function appendMessage(data) {
    $(`
<li class="d-flex justify-content-between mb-4">
    ${data.sender === userID ? '' : '<img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">'}
    <div class="card w-100">
        <div class="card-header d-flex justify-content-between p-3">
            <p class="fw-bold mb-0">${data.senderName}</p>
            <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${data.timestamp} </p>
        </div>
        <div class="card-body">
            <p class="mb-0">
                ${data.message}
            </p>
        </div>
    </div>
    ${data.sender !== userID ? '' : '<img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">'}
</li>
    `).insertBefore($('#chat-box-div form'));
}