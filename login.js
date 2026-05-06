document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    const response = await fetch("login.php", {
        method: "POST",
        body: formData
    });

    const result = await response.json();

    if (result.success) {
        // Redirect to UI page
        window.location.href = "app.php";
    } else {
        document.getElementById("message").innerText = result.message;
    }
});
