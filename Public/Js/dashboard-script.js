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

// A function to run the PHP file that will send the message
function sendWish() {
    return fetch('../../cron/send_wishes.php')
      .then(response => response.text())
      .then(data => {
        console.log(data); // Output the response from the PHP file
        return data; // Return the data for further processing if needed
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

// Function to fetch birthdays from the server
function fetchBirthdays() {
    fetch('../php/get_birthdays.php')
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
    const phone = prompt("Enter Phone number (add country code):");
    if (name && date && phone) {
        fetch('../php/add_birthday.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, date, phone }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Birthday added for ${name} on ${date}, Phone ${phone}`);
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
        const newPhone = prompt("Enter new Phone Number (add country code):", birthday.phone);
        if (newName && newDate && newPhone) {
            fetch('../php/update_birthday.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id, name: newName, date: newDate, phone: newPhone }),
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
        fetch('../php/delete_birthday.php', {
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
        row.insertCell(2).textContent = birthday.phone;

        const actionsCell = row.insertCell(3);
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
function fetchUpcomingBirthdays() {
    fetch('../php/get_upcoming.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const upcomingList = document.getElementById("upcomingBirthdays");
                upcomingList.innerHTML = "";
                data.data.forEach(birthday => {
                    const li = document.createElement("li");
                    li.textContent = `${birthday.name} - ${birthday.date} - ${birthday.phone}`;
                    upcomingList.appendChild(li);
                });
            } else {
                console.error('Error fetching upcoming birthdays:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to fetch and display recent wishes
function fetchRecentWishes() {
    fetch('../php/get_recent.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const wishesList = document.getElementById("recentWishes");
                wishesList.innerHTML = "";
                data.data.forEach(wish => {
                    const li = document.createElement("li");
                    li.textContent = `${wish.name} - ${wish.date} - ${wish.message.substring(0, 30)}...`;
                    wishesList.appendChild(li);
                });
            } else {
                console.error('Error fetching recent wishes:', data.error);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Initialize the application
document.addEventListener('DOMContentLoaded', () => {
    fetchBirthdays();
    fetchUpcomingBirthdays();
    fetchRecentWishes();

    // Add event listener for the "Add Birthday" button
    const addBirthdayBtn = document.getElementById("addBirthdayBtn");
    if (addBirthdayBtn) {
        addBirthdayBtn.addEventListener("click", addBirthday);
    }
});