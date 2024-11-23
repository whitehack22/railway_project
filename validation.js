function validate() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var age = document.getElementById("age");
    var mob = document.getElementById("mob");
    var email = document.getElementById("email");
    var pw = document.getElementById("pw");
    var cpw = document.getElementById("cpw");
    var alphaExp = /^[a-zA-Z]+$/;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    
    if (!fname.value.trim()) {
        alert("Enter a valid first name");
        fname.focus();
        return false;
    }
    if (!fname.value.match(alphaExp)) {
        alert("First name can only contain letters");
        fname.focus();
        return false;
    }

    if (!lname.value.trim()) {
        alert("Enter a valid last name");
        lname.focus();
        return false;
    }
    if (!lname.value.match(alphaExp)) {
        alert("Last name can only contain letters");
        lname.focus();
        return false;
    }

    if (!age.value.trim()) {
        alert("Please enter your age");
        age.focus();
        return false;
    }
    if (isNaN(age.value) || parseInt(age.value) <= 0) {
        alert("Age must be a positive integer");
        age.focus();
        return false;
    }

    
    if (!mob.value.trim()) {
        alert("Please enter a mobile number");
        mob.focus();
        return false;
    }
    if (isNaN(mob.value)) {
        alert("Mobile number must be numeric");
        mob.focus();
        return false;
    }
    if (mob.value.length !== 10) {
        alert("Enter a valid 10-digit mobile number (e.g., 9669666999)");
        mob.focus();
        return false;
    }

    
    if (!email.value.trim()) {
        alert("Please enter an email address");
        email.focus();
        return false;
    }
    if (!email.value.match(emailPattern)) {
        alert("Enter a valid email address");
        email.focus();
        return false;
    }

    
    if (pw.value.length < 8) {
        alert("Password must be at least 8 characters long");
        pw.focus();
        return false;
    }
    if (pw.value !== cpw.value) {
        alert("Passwords do not match");
        cpw.focus();
        return false;
    }

    
    return true;
}
