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