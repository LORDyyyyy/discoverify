<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/socket.io.min.js"></script>
    <!--<script src="https://cdn.socket.io/socket.io-2.2.0.js"></script> -->
    <title>Document</title>
</head>

<body>
    <div id="messages"></div>
    <input id="recipient-input" type="text" placeholder="Recipient">
    <input id="message-input" type="text" placeholder="Message">
    <button id="send-button">Send</button>

    <script>
        let socket = io('http://localhost:3000');

        socket.on('chat', function(data) {
            $('#messages').append($('<p>').text(data));
        });

        $('#send-button').click(function() {
            var recipient = $('#recipient-input').val();
            var message = $('#message-input').val();
            socket.emit('private chat', {
                'recipient': recipient,
                'message': message
            });

            $('#message-input').val('');
        });
    </script>
</body>

<script>
    /*
    document.getElementById('send').addEventListener('click', () => {
        const message = document.getElementById('message').value;

        socket.emit('chat', {
            message: message
        });
    });
    */
</script>

</html>