function validateRegistration() {
    let name = document.getElementById("name").value;
    let mobile = document.getElementById("mobile").value;
    let password = document.getElementById("password").value;
    let confirmPassword =
        document.getElementById("confirm_password").value;
    // Name validation
    let namePattern = /^[A-Za-z ]+$/;
    if (!namePattern.test(name)) {
        alert("Enter a valid name!");
        return false;
    }
    // Mobile validation
    let mobilePattern = /^[0-9]{10}$/;
    if (!mobilePattern.test(mobile)) {
        alert("Mobile number must contain 10 digits!");
        return false;
    }
    // Password validation
    if (password.length < 8) {
        alert("Password must contain at least 8 characters!");
        return false;
    }
    // Confirm password
    if (password !== confirmPassword) {
        alert("Password and Confirm Password do not match!");
        return false;
    }
    return true;
}


function validatePet() {

    let name = document.getElementById("pet_name").value.trim();
    let category = document.getElementById("category").value;
    let age = document.getElementById("age").value;

    let namePattern = /^[A-Za-z ]+$/;

    if (name == "") {
        alert("Please enter pet name!");
        return false;
    }

    if (!namePattern.test(name)) {
        alert("Pet name should contain only letters!");
        return false;
    }

    if (category == "") {
        alert("Please select pet category!");
        return false;
    }

    if (age == "" || age < 0 || age > 100) {
        alert("Please enter a valid pet age!");
        return false;
    }

    return true;
}
