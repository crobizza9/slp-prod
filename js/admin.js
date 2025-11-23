    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("actionModal");
        const form = document.getElementById("actionForm");
        const title = document.getElementById("actionModalTitle");
        const message = document.getElementById("actionModalMessage");
        const userIdField = document.getElementById("actionUserId");

        const roleField = document.getElementById("roleField");
        const passwordFields = document.getElementById("passwordFields");
        const submitBtn = document.getElementById("actionSubmitBtn");

        document.querySelectorAll(".open-action-modal").forEach(button => {
            button.addEventListener("click", function() {

                const action = this.dataset.action;
                const userId = this.dataset.userId;
                const modalTitle = this.dataset.title;
                const modalMessage = this.dataset.message;
                const mode = this.dataset.mode;

                // Set modal text
                title.textContent = modalTitle;
                message.textContent = modalMessage;
                userIdField.value = userId;
                form.action = action;

                // Hide all optional fields
                roleField.classList.add("d-none");
                passwordFields.classList.add("d-none");

                // Mode logic
                if (mode === "role") {
                    roleField.classList.remove("d-none");
                    submitBtn.className = "btn btn-warning";
                } else if (mode === "reset") {
                    passwordFields.classList.remove("d-none");
                    submitBtn.className = "btn btn-primary";
                } else if (mode === "delete") {
                    submitBtn.className = "btn btn-danger";
                }

                // Show modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });
    });
    // Save scroll position before leaving page
    window.addEventListener("beforeunload", function() {
        sessionStorage.setItem("scrollPos", window.scrollY);
    });

    // Restore scroll position after page load
    window.addEventListener("load", function() {
        const scrollPos = sessionStorage.getItem("scrollPos");
        if (scrollPos !== null) {
            window.scrollTo(0, parseInt(scrollPos, 10));
            sessionStorage.removeItem("scrollPos"); // optional: clear after restoring
        }
    });