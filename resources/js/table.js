// const menuButton = document.querySelector(".menuButton");
// const menuPopup = document.querySelector(".menuPopup");

// Toggle popup menu
document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener("click", function (event) {
        const isMenuButton = event.target.closest(".menu-btn");
        const isPopup = event.target.closest(".menu-popup");
        const isDropdownInput = event.target.closest(".dropdown-input");
        const isOptionDropdown = event.target.closest("select > option");
        const btnCloseWarning = event.target.closest("#btnCloseWarning");

        // Tutup semua popup yang terbuka
        document.querySelectorAll(".menu-popup").forEach((popup) => {
            if (!popup.contains(event.target)) {
                popup.classList.add("hidden");
            }
        });

        // Jika yang diklik adalah menu button, tampilkan popup yang sesuai
        if (isMenuButton) {
            const containerTable = document.getElementById("container-table");
            const popup =
                isMenuButton.parentElement.querySelector(".menu-popup");
            const rectMenuButton = isMenuButton.getBoundingClientRect();
            const rectContainerTable = containerTable.getBoundingClientRect();

            // Posisi popup
            // popup.style.top = `${rectMenuButton.top - 20}px`;
            // popup.style.right = `${rectContainerTable.right}px`;

            popup.classList.toggle("hidden");
        }

        if (!isMenuButton && !isPopup) {
            document.querySelectorAll(".menu-popup").forEach((popup) => {
                popup.classList.add("hidden");
            });
        }

        if (isDropdownInput) {
            const isIconDropdown =
                isDropdownInput.querySelector("#icon-dropdown");
            isIconDropdown.classList.toggle("rotate-180");
        }

        if (btnCloseWarning) {
            document.getElementById("warning-modal").classList.add("hidden");
        }

        // if (!isDropdownInput && !isOptionDropdown) {
        //     console.log(!isDropdownInput && !isOptionDropdown);
        //     const isIconDropdown =
        //         isDropdownInput.querySelector("icon-dropdown");
        //     if (
        //         isIconDropdown &&
        //         isIconDropdown.classList.contains("rotate-180")
        //     ) {
        //         isIconDropdown.classList.remove("rotate-180");
        //     }
        // }
    });

    // Toast Couriers
    const toastSuccess = document.getElementById("toast-success");
    if (toastSuccess) {
        toastSuccess.classList.remove("opacity-0");
        toastSuccess.classList.remove("hidden");
        toastSuccess.classList.add("flex");
        setTimeout(() => {
            setTimeout(() => {
                toastSuccess.classList.add("opacity-0");
                setTimeout(() => {
                    toastSuccess.classList.remove("flex");
                    toastSuccess.classList.add("hidden");
                }, 300);
            }, 300);
        }, 1000);
    }

    const toastDanger = document.getElementById("toast-danger");
    if (toastDanger) {
        toastDanger.classList.remove("opacity-0");
        toastDanger.classList.remove("hidden");
        toastDanger.classList.add("flex");
        setTimeout(() => {
            setTimeout(() => {
                toastDanger.classList.add("opacity-0");
                setTimeout(() => {
                    toastDanger.classList.remove("flex");
                    toastDanger.classList.add("hidden");
                }, 300);
            }, 300);
        }, 1000);
    }

    // Modal Delete
    const btnDeletes = document.querySelectorAll(".btn-hapus");
    const btnCloseModal = document.getElementById("btnCloseModal");

    if (btnDeletes) {
        btnDeletes.forEach((btn) => {
            btn.addEventListener("click", () => {
                openDeleteModal(btn.getAttribute("data-url"));
                btnCloseModal.addEventListener("click", () => {
                    closeDeleteModal();
                });
            });
        });
    }
});
const openDeleteModal = (url) => {
    // Ubah action form sesuai dengan ID yang dipilih
    document.getElementById("delete-form").setAttribute("action", url);

    document.getElementById("delete-modal").classList.remove("hidden");
    document.getElementById("delete-modal").classList.add("flex");
};

const closeDeleteModal = () => {
    document.getElementById("delete-modal").classList.add("hidden");
    document.getElementById("delete-modal").classList.remove("flex");
};
