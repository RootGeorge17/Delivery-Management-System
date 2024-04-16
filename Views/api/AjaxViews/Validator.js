
class Validator {
    renderAlert(response) {
        const alertDiv = document.querySelector('.alert.alert-danger');
        if (alertDiv) {
            const li = alertDiv.querySelector('li');
            if (li) {
                li.textContent = response;
                alertDiv.classList.remove('hide');
                console.log(alertDiv);

                // Add close icon dynamically
                const closeIcon = document.createElement('span');
                closeIcon.className = 'bi bi-x';
                li.appendChild(closeIcon);

                // Add event listener to close icon
                closeIcon.addEventListener('click', function() {
                    alertDiv.classList.add('hide');
                    console.log(alertDiv);
                });
            }
        }
    }

}


