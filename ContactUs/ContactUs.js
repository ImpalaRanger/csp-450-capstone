document.getElementById('contactForm').addEventListener('submit', function(event) {
    var emailInput = document.getElementById('email');

    if (!isValidEmail(emailInput.value)) {
        alert('Please enter a valid email address.');
        event.preventDefault(); // Prevent the form from submitting
    }
});

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
