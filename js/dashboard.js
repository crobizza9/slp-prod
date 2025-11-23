    document.addEventListener("DOMContentLoaded", () => {
        const statusElements = document.querySelectorAll(".status-filter");
        const showAllBtn = document.getElementById("showAll");

        statusElements.forEach(box => {
            box.style.cursor = "pointer";

            box.addEventListener("click", () => {
                const status = box.dataset.status;

                // navigate with GET param
                window.location.href = `?status=${encodeURIComponent(status)}`;
            });
        });

        // If filtered, show the Show All button
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("status")) {
            showAllBtn.classList.remove("d-none");
        }

        showAllBtn.addEventListener("click", () => {
            window.location.href = "?status=all";
        });
    });