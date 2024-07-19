  // Sample data (replace with actual data from your backend)
  const upcomingBirthdays = [
    { name: "Manasseh Qharney", date: "2024-07-25" },
    { name: "Jude Smith", date: "2024-08-03" },
    { name: "Selasi Johnson", date: "2024-08-10" }
];

const recentWishes = [
    { name: "Alice Brown", date: "2024-07-15" },
    { name: "Bob Wilson", date: "2024-07-10" },
    { name: "Carol Taylor", date: "2024-07-05" }
];

// Populate upcoming birthdays
const upcomingList = document.getElementById("upcomingBirthdays");
upcomingBirthdays.forEach(birthday => {
    const li = document.createElement("li");
    li.textContent = `${birthday.name} - ${birthday.date}`;
    upcomingList.appendChild(li);
});

// Populate recent wishes
const wishesList = document.getElementById("recentWishes");
recentWishes.forEach(wish => {
    const li = document.createElement("li");
    li.textContent = `${wish.name} - ${wish.date}`;
    wishesList.appendChild(li);
});

// Function to add a new birthday
function addBirthday() {
    const name = prompt("Enter the person's name:");
    const date = prompt("Enter the birthday (YYYY-MM-DD):");
    if (name && date) {
        alert(`Birthday added for ${name} on ${date}`);
        // Here you would typically send this data to your backend
    }
}

// Function to send a birthday wish
function sendWish() {
    const name = prompt("Enter the person's name:");
    if (name) {
        alert(`Birthday wish sent to ${name}`);
        // Here you would typically send this data to your backend
    }
}
    // Function to update the birthday table
    function updateBirthdayTable() {
        const tableBody = document.querySelector("#birthdayTable tbody");
        tableBody.innerHTML = "";

        birthdays.forEach(birthday => {
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

    // Function to edit a birthday
    function editBirthday(id) {
        const birthday = birthdays.find(b => b.id === id);
        if (birthday) {
            const newName = prompt("Enter new name:", birthday.name);
            const newDate = prompt("Enter new date (YYYY-MM-DD):", birthday.date);
            if (newName && newDate) {
                birthday.name = newName;
                birthday.date = newDate;
                updateBirthdayTable();
            }
        }
    }

    // Function to delete a birthday
    function deleteBirthday(id) {
        if (confirm("Are you sure you want to delete this birthday?")) {
            birthdays = birthdays.filter(b => b.id !== id);
            updateBirthdayTable();
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

    // Initial table population
    updateBirthdayTable();