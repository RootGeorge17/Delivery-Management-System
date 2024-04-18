class Livesearch extends Ajax {
    constructor() {
        super();
        this.searchInputDeliveries = document.getElementById('searchInputDeliveries');
        this.resultsDropdown = document.getElementById('resultsDropdown');
        this.filterCheckboxes = document.querySelectorAll('.form-check-input');
        this.checkboxes = document.querySelectorAll("input[type=checkbox]");
        this.keyword = '';
        this.currentPage = 1;
        this.resultsPerPage = 5;
        this.setMaxWidth();
        this.initEvents();
    }

    initEvents() {
        window.addEventListener('resize', this.setMaxWidth.bind(this));
        this.searchInputDeliveries.addEventListener('keyup', this.handleSearchInput.bind(this));
        this.checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', this.handleCheckboxChange.bind(this));
        });

        document.addEventListener('click', this.handleDocumentClick.bind(this));
    }

    handleDocumentClick(event) {
        // Check if the click target is outside of search input, results dropdown, and filter dropdown
        if (!event.target.closest('#searchInputDeliveries') &&
            !event.target.closest('#resultsDropdown') &&
            !event.target.closest('#filterDropdown')) {
            this.resultsDropdown.style.display = 'none';
        } else {
            this.setMaxWidth();
            this.resultsDropdown.style.display = 'block';
        }
    }

    setMaxWidth() {
        const searchInputWidth = this.searchInputDeliveries.offsetWidth;
        this.resultsDropdown.style.width = `${searchInputWidth}px`;
    }

    handleSearchInput() {
        const conditions = this.getCheckedConditions();
        this.keyword = this.searchInputDeliveries.value;
        this.currentPage = 1;
        this.setMaxWidth();
        this.liveSearch(this.keyword, conditions);
    }

    handleCheckboxChange() {
        const conditions = this.getCheckedConditions();
        if (this.keyword.length > 0) {
            this.currentPage = 1;
            this.liveSearch(this.keyword, conditions);
        }
    }

    getCheckedConditions() {
        const conditions = [];
        this.filterCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                conditions.push(checkbox.value);
            }
        });
        return conditions;
    }

    liveSearch(keyword, conditions) {
        const conditionsQuery = conditions.map(condition => `condition[]=${condition}`).join('&');
        const baseUrl = `/livesearch?action=search-delivery&keyword=${keyword}&${conditionsQuery}&page=${this.currentPage}&resultsPerPage=${this.resultsPerPage}`;
        const url = this.addTokenToUrl(baseUrl);
        console.log(url);

        this.get(url, (error, response) => {
            if (error) {
                console.log(error);
            } else {
                const result = JSON.parse(response);
                console.log("Fetched parcels for Live Search: \n ", result);

                this.renderResults(result);
            }
        });
    }

    renderResults(results) {
        const nextPage = this.currentPage + 1;
        const lastPage = this.currentPage - 1;

        // Clear previous results
        this.resultsDropdown.innerHTML = '';

        // Add pagination controls
        const pagination = this.createPaginationControls(lastPage, nextPage, results.length);
        this.resultsDropdown.appendChild(pagination);

        if (results.length > 0) {
            // Add an option for each result, limited to the resultsPerPage value
            for (let i = 0; i < results.length; i++) {
                const listItem = document.createElement('li');
                listItem.innerHTML = `<a class="dropdown-item" href="/?parcel=${results[i].id}">ID: ${results[i].id}, Name: ${results[i].name}, Address: ${results[i].address_1} ${results[i].address_2}, Postcode: ${results[i].postcode}</a>`;
                this.resultsDropdown.appendChild(listItem);
            }

            this.resultsDropdown.style.display = 'block';
        }

        if (results.length === 0) {
            this.resultsDropdown.style.display = 'block';
            const error = document.createElement('p');
            error.innerHTML = `No Results`;
            this.resultsDropdown.appendChild(error);
        }

        if (this.keyword.length === 0) {
            this.resultsDropdown.style.display = 'none';
        }
    }

    createPaginationControls(lastPage, nextPage, resultsCount) {
        const pagination = document.createElement('div');
        pagination.classList.add('pagination', 'd-flex', 'justify-content-center');

        const prevButton = document.createElement('button');
        prevButton.textContent = `Previous (Page: ${lastPage})`;
        prevButton.disabled = this.currentPage === 1;
        prevButton.classList.add('w-100');
        prevButton.addEventListener('click', (event) => {
            event.preventDefault();
            this.currentPage--;
            this.liveSearch(this.keyword, this.getCheckedConditions());
        });

        const nextButton = document.createElement('button');
        nextButton.textContent = `Next (Page: ${nextPage})`;
        nextButton.disabled = resultsCount < this.resultsPerPage;
        nextButton.classList.add('w-100');
        nextButton.addEventListener('click', (event) => {
            event.preventDefault();
            this.currentPage++;
            this.liveSearch(this.keyword, this.getCheckedConditions());
        });

        pagination.appendChild(prevButton);
        pagination.appendChild(nextButton);
        return pagination;
    }
}

// Instantiate the LiveSearch class
const livesearch = new Livesearch();