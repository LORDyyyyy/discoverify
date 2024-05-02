<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo esc($title); ?> </title>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Sender ID</th>
                    <th>Timestamp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                        <td class="action-buttons">
                            <form action="/requests" method="post">
                                <input type="hidden" name="status" value="2">
                                <button type="submit">Accept</button>
                            </form>
                            <form action="/requests" method="post">
                                <input type="hidden" name="status" value="3">
                                <button type="submit">Decline</button>
                            </form>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
