
class Validator {
    renderAlert(response) {
        const alertDiv = document.querySelector('.alert.alert-danger');
        if (alertDiv) {
            const li = alertDiv.querySelector('li');
            if (li) {
                li.textContent = response;
                alertDiv.classList.remove('hide');

                setTimeout(() => {
                    alertDiv.classList.add('hide');
                }, 10000);
            }
        }
    }
}


