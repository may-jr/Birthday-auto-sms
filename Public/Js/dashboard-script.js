// Toggle sidebar
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('main-content');
const toggleBtn = document.getElementById('toggleSidebar');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
});

// Navigation
const navLinks = document.querySelectorAll('#sidebar a');
const sections = document.querySelectorAll('main section');

navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = link.getAttribute('href').substring(1);
        sections.forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById(targetId).classList.add('active');
    });
});

// Global variables
let birthdays = [];

// Function to fetch birthdays from the server
function fetchBirthdays() {
    fetch('get_birthdays.php')
        .then(response => response.json())
        .then(data => {
            birthdays = data;
            updateBirthdayTable();
            updateUpcomingBirthdays();
        })
        .catch(error => console.error('Error:', error));
}

// Function to add a new birthday
function addBirthday() {
    const name = prompt("Enter the person's name:");
    const date = prompt("Enter the birthday (YYYY-MM-DD):");
    if (name && date) {
        fetch('add_birthday.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, date }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Birthday added for ${name} on ${date}`);
                fetchBirthdays();
            } else {
                alert('Failed to add birthday');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Function to edit a birthday
function editBirthday(id) {
    const birthday = birthdays.find(b => b.id === id);
    if (birthday) {
        const newName = prompt("Enter new name:", birthday.name);
        const newDate = prompt("Enter new date (YYYY-MM-DD):", birthday.date);
        if (newName && newDate) {
            fetch('update_birthday.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id, name: newName, date: newDate }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Birthday updated for ${newName}`);
                    fetchBirthdays();
                } else {
                    alert('Failed to update birthday');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
}

// Function to delete a birthday
function deleteBirthday(id) {
    if (confirm("Are you sure you want to delete this birthday?")) {
        fetch('delete_birthday.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Birthday deleted successfully');
                fetchBirthdays();
            } else {
                alert('Failed to delete birthday');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Filter and sort functionality
const filterInput = document.getElementById("filterInput");
const sortSelect = document.getElementById("sortSelect");

filterInput.addEventListener("input", updateBirthdayTable);
sortSelect.addEventListener("change", updateBirthdayTable);

function updateBirthdayTable() {
    let filteredBirthdays = birthdays.filter(birthday =>
        birthday.name.toLowerCase().includes(filterInput.value.toLowerCase())
    );

    filteredBirthdays.sort((a, b) => {
        if (sortSelect.value === "name") {
            return a.name.localeCompare(b.name);
        } else {
            return new Date(a.date) - new Date(b.date);
        }
    });

    const tableBody = document.querySelector("#birthdayTable tbody");
    tableBody.innerHTML = "";

    filteredBirthdays.forEach(birthday => {
        const row = tableBody.insertRow();
        row.insertCell(0).textContent = birthday.name;
        row.insertCell(1).textContent = birthday.date;
        
        const actionsCell = row.insertCell(2);
        const editButton = document.createElement("button");
        editButton.textContent = "Edit";
        editButton.onclick = () => editBirthday(birthday.id);
        
        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Delete";
        deleteButton.onclick = () => deleteBirthday(birthday.id);
        
        actionsCell.appendChild(editButton);
        actionsCell.appendChild(deleteButton);
    });
}

// Function to update upcoming birthdays
function updateUpcomingBirthdays() {
    const upcomingList = document.getElementById("upcomingBirthdays");
    upcomingList.innerHTML = "";

    const today = new Date();
    const upcomingBirthdays = birthdays
        .filter(birthday => {
            const birthdayDate = new Date(birthday.date);
            birthdayDate.setFullYear(today.getFullYear());
            if (birthdayDate < today) {
                birthdayDate.setFullYear(today.getFullYear() + 1);
            }
            const timeDiff = birthdayDate.getTime() - today.getTime();
            const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            return dayDiff <= 30;
        })
        .sort((a, b) => new Date(a.date) - new Date(b.date));

    upcomingBirthdays.forEach(birthday => {
        const li = document.createElement("li");
        li.textContent = `${birthday.name} - ${birthday.date}`;
        upcomingList.appendChild(li);
    });
}

// Initialize the application
document.addEventListener('DOMContentLoaded', () => {
    fetchBirthdays();
    
    // Add event listener for the "Add Birthday" button
    const addBirthdayBtn = document.getElementById("addBirthdayBtn");
    if (addBirthdayBtn) {
        addBirthdayBtn.addEventListener("click", addBirthday);
    }
});