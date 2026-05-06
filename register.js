document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registerForm");

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        // Collect all fields
        const data = {
            first_name: document.getElementById("first_name").value.trim(),
            last_name: document.getElementById("last_name").value.trim(),
            username: document.getElementById("username").value.trim(),
            email: document.getElementById("email").value.trim(),
            password: document.getElementById("password").value.trim(),
            confirm_password: document.getElementById("confirm_password").value.trim(),
            city: document.getElementById("city").value.trim(),
            state: document.getElementById("state").value.trim()
        };

        try {
            const response = await fetch("register.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            // Show backend message
            alert(result.message);

            // If successful, redirect to login
            if (result.success) {
                window.location.href = "login.html";
            }

        } catch (error) {
            alert("A network error occurred. Please try again.");
            console.error(error);
        }
    });

});
