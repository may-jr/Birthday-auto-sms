<?php
require_once '../php/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Dashboard</title>
</head>

<body>
    <header>
        <div class="logo">Birthday Wishing System</div>
        <div class="user-info">
            <span>Welcome, User</span>
            <button id="logoutBtn"><a href="../php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></button>
        </div>
    </header>

    <div class="content-wrapper">
        <nav id="sidebar">
            <button id="toggleSidebar"><i class="fas fa-bars"></i></button>
            <ul>
                <li><a href="#dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#birthdays"><i class="fas fa-birthday-cake"></i> Birthdays</a></li>
                <li><a href="#wishes"><i class="fas fa-envelope"></i> Wishes</a></li>
                <li><a href="#settings"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </nav>

        <main id="main-content">
            <section id="dashboard" class="active">
                <h1>Dashboard</h1>
                <div class="card-container">
                    <div class="card">
                        <h2>Upcoming Birthdays</h2>
                        <ul id="upcomingBirthdays"></ul>
                    </div>
                    <div class="card">
                        <h2>Recent Birthday Wishes Sent</h2>
                        <ul id="recentWishes"></ul>
                    </div>
                    <div class="card">
                        <h2>Quick Actions</h2>
                        <button onclick="addBirthday()">Add New Birthday</button>
                        <button onclick="sendWish()">Send Birthday Wish</button>
                    </div>
                </div>
            </section>

            <section id="birthdays">
                <h1>Birthday Management</h1>
                <div class="filter-sort">
                    <input type="text" id="filterInput" placeholder="Filter by name">
                    <select id="sortSelect">
                        <option value="name">Sort by Name</option>
                        <option value="date">Sort by Date</option>
                    </select>
                </div>
                <table id="birthdayTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>

            <section id="wishes">
                <h1>Wish Management</h1>
                <!-- Add wish management content here -->
            </section>

            <section id="settings">
                <h1>Settings</h1>
                <!-- Add settings content here -->
                <!-- Add this near the top of your dashboard, perhaps next to the logout button -->
                <button id="theme-toggle" class="theme-toggle-btn">Toggle Dark Mode</button>
            </section>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Birthday Wishing System. All rights reserved.</p>
    </footer>

    <script src="../js/dashboard-script.js"></script>
</body>

</html>