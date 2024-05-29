document.addEventListener('DOMContentLoaded', function() {
    function validateEmail() {
        const email = document.getElementById('inp_uname').value;
        const errorElement = document.getElementById('error_uname');
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailPattern.test(email)) {
            errorElement.textContent = "Enter a valid email address.";
            return false;
        }

        errorElement.textContent = "";
        return true;
    }

    const emailForm = document.getElementById('emailForm');
    emailForm.addEventListener('submit', function(event) {
        if (!validateEmail()) {
            event.preventDefault();
        }
    });
});
