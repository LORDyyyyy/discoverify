const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword") ?? null;
const eyes = document.querySelectorAll(".fa-eye");

eyes[0].addEventListener("click", () => {
    if (password.type === "password") {
        password.type = "text";
        eye.classList.remove("fa-eye");
        eye.classList.add("fa-eye-slash");
    } else {
        password.type = "password";
        eye.classList.remove("fa-eye-slash");
        eye.classList.add("fa-eye");
    }
});

if (confirmPassword) {
    eyes[1].addEventListener("click", () => {
        if (confirmPassword.type === "password") {
            confirmPassword.type = "text";
            eye.classList.remove("fa-eye");
            eye.classList.add("fa-eye-slash");
        } else {
            confirmPassword.type = "password";
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        }
    });
}