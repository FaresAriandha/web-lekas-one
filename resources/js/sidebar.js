document.addEventListener("DOMContentLoaded", () => {
    const btnSidebarOpen = document.getElementById("btn-sidebar-open");
    const btnSidebarClose = document.getElementById("btn-sidebar-close");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");
    const btnPassword = document.querySelector(".btn-password");

    if (btnSidebarOpen || btnSidebarClose) {
        btnSidebarOpen.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-64");
            sidebar.classList.toggle("opacity-100");
            overlay.classList.toggle("hidden");
            overlay.classList.remove("opacity-0");
            overlay.classList.add("opacity-30");
        });

        btnSidebarClose.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-64");
            sidebar.classList.toggle("opacity-100");
            overlay.classList.toggle("hidden");
            overlay.classList.remove("opacity-30");
            overlay.classList.add("opacity-0");
        });
    }

    const togglePassword = () => {
        const passwordInput = document.getElementById("password");
        const eyeOpen = document.getElementById("eyeOpen");
        const eyeClose = document.getElementById("eyeClose");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
        eyeOpen.classList.toggle("hidden");
        eyeClose.classList.toggle("hidden");
    };

    if (btnPassword) {
        btnPassword.addEventListener("click", togglePassword);
    }
});
