document.addEventListener('DOMContentLoaded', () => {
    fetchBirthdays();
});

function fetchBirthdays() {
    fetch('get_birthdays.php')
        .then(response => response.json())
        .then(data => {
            const birthdaysDiv = document.getElementById('birthdays');
            birthdaysDiv.innerHTML = '';
            data.forEach(birthday => {
                birthdaysDiv.innerHTML += `<p>${birthday.name}: ${birthday.birth_date}</p>`;
            });
        });
}