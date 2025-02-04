// Show alert messages for a few seconds and fade out
document.addEventListener("DOMContentLoaded", function () {
    let alerts = document.querySelectorAll(".alert");
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});

// Confirm before deleting users or books
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-btn")) {
        if (!confirm("Are you sure you want to delete this?")) {
            e.preventDefault();
        }
    }
});
