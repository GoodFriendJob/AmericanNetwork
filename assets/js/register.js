console.log("REGISTER JS LOADED");
document.getElementById("registerForm").addEventListener("submit", async function(e) {
    e.preventDefault();

      const first_name = document.getElementById("first_name").value;
    const last_name = document.getElementById("last_name").value;
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirm_password = document.getElementById("confirm_password").value;
    const city = document.getElementById("city").value;
    const state = document.getElementById("state").value;

    const data = {
        first_name: first_name,
        last_name: last_name,
        username: username,
        email: email,
        password: password,
        confirm_password: confirm_password,
        city: city,
        state: state
    };

    try {
        const response = await fetch("register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            alert("Account created! Please check your email to verify your account.");
            window.location.href = "login.html";
        } else {
            alert(result.message);
        }

    } catch (error) {
        alert("An error occurred. Please try again.");
    }
});
