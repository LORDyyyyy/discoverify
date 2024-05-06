const requestsCount = document.getElementById('requestsCount');

const deleteButtons = document.querySelectorAll('.declineBtn');

deleteButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        const requestDiv = event.target.closest('div');
        const requestID = requestDiv.querySelector('input').value;

        fetch('/api/requests', {
            method: 'DELETE',
            body: JSON.stringify({
                id: requestID
            }),
        }).then(async response => {
            if (!response.ok) {
                return;
            }
            event.target.closest('li').remove();
            requestsCount.textContent = parseInt(requestsCount.textContent) - 1;
        });
    });
});

const acceptButtons = document.querySelectorAll('.acceptBtn');
acceptButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        const requestDiv = event.target.closest('div');
        const requestID = requestDiv.querySelector('input').value;

        fetch('/api/requests', {
            method: 'PUT',
            body: JSON.stringify({
                id: requestID
            }),
        }).then(async response => {
            if (!response.ok) {
                return;
            }
            event.target.closest('li').remove();
            requestsCount.textContent = parseInt(requestsCount.textContent) - 1;
        });
    });
});
