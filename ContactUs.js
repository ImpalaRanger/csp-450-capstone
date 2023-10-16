// JavaScript for form validation could go here
document.getElementById('contact-form').addEventListener('submit', function (event) {
    // Perform any validation you need here
    // Example: Check if the email is valid
    var emailInput = document.getElementById('email');
    if (!isValidEmail(emailInput.value)) {
        alert('Please enter a valid email address.');
        event.preventDefault(); // Prevent the form from submitting
    }
});

function isValidEmail(email) {
    // A simple email validation function, you might want to use a more robust one
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}