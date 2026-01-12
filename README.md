# Delivery Management System

## Overview

This project is a comprehensive Delivery Management System designed for a small delivery company to log, track, and manage parcel deliveries and deliverers. It provides a role-based interface for both **Managers** and **Deliverers** with distinct functionalities tailored to their responsibilities.

The system is structured using the MVC design pattern and OOP principles, facilitating enhanced scalability and robust, maintainable code. It is designed to handle significant data volumes while maintaining performance.

## Key Features

*   **Architectural Design:**
    *   Built using the **MVC (Model-View-Controller)** design pattern for a clean separation of concerns.
    *   Employs the **Singleton design pattern** for the database connection, ensuring a single, globally accessible instance to optimize resource management.
    *   A custom routing system handles incoming HTTP requests, providing user-friendly URLs.

*   **User & Session Management:**
    *   Secure user authentication with encrypted password storage.
    *   Role-based authorization (**Manager**, **Deliverer**) to secure access to different pages and features.
    *   Anti-spam protection on the login form.

*   **Manager Functionality:**
    *   Dashboard with key statistics (total parcels, total deliverers).
    *   Full **CRUD** (Create, Read, Update, Delete) operations for both delivery parcels and deliverer accounts.
    *   Assign and re-assign parcels to specific deliverers.
    *   Update delivery statuses (Pending, Shipped, Out for delivery, Delivered).
    *   Live search functionality with multiple filters (ID, name, postcode, address) for parcels.
    *   Interactive map view (using Leaflet.js) showing all non-delivered parcels, with markers providing details and a QR code for quick lookup.

*   **Deliverer Functionality:**
    *   Personalized dashboard displaying only assigned parcels.
    *   Ability to update parcel status to "Delivered" or "No Answer".
    *   Interactive map view showing locations of their assigned parcels.
    *   Search assigned parcels.

*   **Security & Data Integrity:**
    *   Uses prepared statements to prevent SQL injection attacks.
    *   Implements server-side input validation and robust exception handling to ensure data integrity.

## Technologies Used

*   **Backend:** PHP
*   **Frontend:** JavaScript, HTML, CSS, Bootstrap 5
*   **Database:** MySQL
*   **JavaScript Libraries:**
    *   **Leaflet.js:** For interactive maps.
    *   **QRCode.js:** For generating QR codes.
    *   **AJAX:** For dynamic updates without page reloads (live search, status updates, map data).

## Installation and Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/rootgeorge17/delivery-management-system.git
    cd delivery-management-system
    ```

2.  **Database Setup:**
    *   Create a MySQL database.
    *   You will need to manually create the required tables as a schema file is not provided. Based on the code, the necessary tables are:
        *   `delivery_point`
        *   `delivery_status`
        *   `delivery_users`
        *   `delivery_usertype`
    *   Populate the `delivery_status` and `delivery_usertype` tables with initial data (e.g., statuses: `1:Pending`, `2:Shipped`, `3:Out for delivery`, `4:Delivered`; user types: `1:Manager`, `2:Deliverer`).

3.  **Configuration:**
    *   Open `config.php` and update the database host and name:
        ```php
        'database' => [
            'host' => 'your_db_host', // e.g., 'localhost'
            'dbname' => 'your_db_name',
            'charset' => 'utf8mb4'
        ],
        ```
    *   Open `Models/Core/Database.php` and update the hardcoded database credentials on line 28:
        ```php
        // From:
        self::$dbInstance = new self($config['database'], $username = 'sgc017', $password = 'LF3VbFtiP4UX6Cy');

        // To:
        self::$dbInstance = new self($config['database'], 'your_db_username', 'your_db_password');
        ```

4.  **Web Server:**
    *   Configure a web server (like Apache) to point its document root to the project directory.
    *   For Apache, ensure the `mod_rewrite` module is enabled to support the `.htaccess` file for clean URLs.

## Usage Guide

*   **Login:** Access the application through your server's URL. You can log in as either a Manager or a Deliverer.

*   **Manager Role:**
    *   After logging in, you are directed to the Admin Panel.
    *   The dashboard displays statistics for total deliveries and deliverers.
    *   Use the "Show All Parcels" and "Show All Deliverers" buttons to view and manage data tables with pagination.
    *   Each parcel card allows you to update its status, assign a deliverer, edit its details, or delete it using modals.
    *   Use the "Create new Parcel" or "Create new User" buttons to add new entries.
    *   The map can be loaded to visualize all active delivery locations.

*   **Deliverer Role:**
    *   After logging in, you will see a dashboard displaying only the parcels assigned to you.
    *   You can view details for each parcel and update its status. "Mark as Delivered" completes the delivery, while "Mark as No Answer" reverts the status to "Out for delivery".
    *   Loading the map will show only your assigned delivery points.
