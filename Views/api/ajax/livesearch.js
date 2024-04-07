window.addEventListener('resize', function() {
    setMaxWidth();
});

function setMaxWidth() {
    const searchInputWidth = document.getElementById('searchInputDeliveries').offsetWidth;
    document.getElementById('resultsDropdown').style.width = `${searchInputWidth}px`;
}

// Call setMaxWidth initially to set the initial max width
setMaxWidth();

const searchInputDeliveries = document.getElementById('searchInputDeliveries');
const resultsDropdown = document.getElementById('resultsDropdown');
const filterCheckboxes = document.querySelectorAll('.form-check-input');
const checkboxes = document.querySelectorAll("input[type=checkbox]");
let keyword = '';

searchInputDeliveries.addEventListener('keyup', function() {
    const conditions = [];

    filterCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            conditions.push(checkbox.value);
        }
    });

    keyword = this.value;
    liveSearch(this.value, conditions);
});

checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function () {
        const conditions = [];

        filterCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                conditions.push(checkbox.value);
            }
        });

        liveSearch(keyword, conditions);
    });
});

function liveSearch(keyword, conditions) {
    const xhr = new XMLHttpRequest();
    const conditionsQuery = conditions.map((condition) => `condition[]=${condition}`).join('&');
    const url = `/livesearch?action=search-delivery&keyword=${keyword}&${conditionsQuery}`;
    xhr.open('GET', url);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const result = JSON.parse(xhr.responseText);
                console.log(result[0]);

                // Clear previous results
                resultsDropdown.innerHTML = '';

                if (result.length > 0) {
                    // Add an option for each result, limited to 5
                    for (let i = 0; i < Math.min(result.length, 5); i++) {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `<a class="dropdown-item" href="/?search=${keyword}">ID: ${result[i].id}, Name: ${result[i].name}, Address: ${result[i].address_1} ${result[i].address_2}, Postcode: ${result[i].postcode}</a>`;
                        resultsDropdown.appendChild(listItem);
                    }

                    // Show the dropdown
                    resultsDropdown.style.display = 'block';
                } else {
                    // If no results, hide the dropdown
                    resultsDropdown.style.display = 'none';
                }
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.send();
}