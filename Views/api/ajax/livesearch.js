window.addEventListener('resize', function() {
    setMaxWidth();
});

function setMaxWidth() {
    const searchInputWidth = document.getElementById('searchInputDeliveries').offsetWidth;
    document.getElementById('resultsDropdown').style.width = `${searchInputWidth}px`;
}

setMaxWidth();

const searchInputDeliveries = document.getElementById('searchInputDeliveries');
const resultsDropdown = document.getElementById('resultsDropdown');
const filterCheckboxes = document.querySelectorAll('.form-check-input');
const checkboxes = document.querySelectorAll("input[type=checkbox]");
let keyword = '';
let currentPage = 1;
const resultsPerPage = 5;
const ajax = new window.Ajax(); // Create an instance of the Ajax class

searchInputDeliveries.addEventListener('keyup', function() {
    const conditions = [];

    filterCheckboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            conditions.push(checkbox.value);
        }
    });

    keyword = this.value;
    currentPage = 1;
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

        if (keyword.length > 0) {
            currentPage = 1;
            liveSearch(keyword, conditions);
        }
    });
});

function liveSearch(keyword, conditions) {
    const conditionsQuery = conditions.map((condition) => `condition[]=${condition}`).join('&');
    const url = `/livesearch?action=search-delivery&keyword=${keyword}&${conditionsQuery}&page=${currentPage}&resultsPerPage=${resultsPerPage}`;
    console.log(url);

    ajax.get(url, (error, response) => {
        if (error) {
            console.error('Error:', error);
        } else {
            const result = JSON.parse(response);
            console.log("Fetched parcels for Live Search: \n ", result);
            var nextPage = currentPage + 1;
            var lastPage = currentPage + - 1;

            // Clear previous results
            resultsDropdown.innerHTML = '';

            // Add pagination controls
            const pagination = document.createElement('div');
            pagination.classList.add('pagination', 'd-flex', 'justify-content-center'); // Add Bootstrap classes for flexbox and centering

            const prevButton = document.createElement('button');
            prevButton.textContent = 'Previous (Page: ' + lastPage + ')';
            prevButton.disabled = currentPage === 1;
            prevButton.classList.add('w-100');
            prevButton.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent form submission
                currentPage--;
                liveSearch(keyword, conditions);
            });

            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next (Page: ' + nextPage + ')';
            nextButton.disabled = result.length < resultsPerPage;
            nextButton.classList.add('w-100');
            nextButton.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent form submission
                currentPage++;
                liveSearch(keyword, conditions);
            });

            pagination.appendChild(prevButton);
            pagination.appendChild(nextButton);
            resultsDropdown.appendChild(pagination);

            if (result.length > 0) {
                // Add an option for each result, limited to the resultsPerPage value
                for (let i = 0; i < result.length; i++) {
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
        }
    });
}
