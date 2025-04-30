document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll("input[data-char-count]");
    const uploadBtnImg = document.getElementById("courier_img");
    const chosenImg = document.getElementById("img-preview");
    const uploadBtnPDF = document.querySelectorAll(".upload-pdf");
    const uploadExcelFile = document.querySelectorAll(".upload-excel");
    const datetimepicker = document.querySelectorAll(".datetimepicker");

    if (inputs) {
        inputs.forEach((input) => {
            // console.log(input);
            input.addEventListener("input", updateCharacterCount);
            // Hitung pertama kali saat load
            updateCharacterCount({ target: input });
        });
    }

    if (uploadBtnImg) {
        uploadBtnImg.onchange = () => {
            previewImage(uploadBtnImg, chosenImg);
        };
    }

    if (uploadBtnPDF) {
        uploadBtnPDF.forEach((btn) => {
            btn.addEventListener("change", () => {
                const showBtnPDF = btn.nextElementSibling;
                previewPDF(btn, showBtnPDF);
            });
        });
    }

    if (uploadExcelFile) {
        uploadExcelFile.forEach((btn) => {
            btn.addEventListener("change", () => {
                const downloadFile = btn.nextElementSibling;
                downloadUploadedFile(btn, downloadFile);
            });
        });
    }

    if (datetimepicker) {
        // flatpickr(".datetimepicker", {
        //     enableTime: true,
        //     dateFormat: "Y-m-d H:i:ss",
        //     time_24hr: true,
        // });
    }

    // new Datepicker(monthPicker, {
    //     autohide: true,
    //     format: "yyyy-mm", // Output: 2025-04
    //     pickLevel: 1, // << ini penting! pickLevel:1 = pilih BULAN saja
    // });
});

const updateCharacterCount = (e) => {
    const input = e.target;
    let maxCount = 100; // default

    if (
        input.type === "text" ||
        input.type === "textarea" ||
        input.type === "email" ||
        input.type === "password"
    ) {
        maxCount = input.getAttribute("maxlength") || 100;
    } else if (input.type === "number") {
        const maxAttr = input.getAttribute("max");
        maxCount = maxAttr ? String(maxAttr).length : 100;
    }

    const charCountSpan = input.parentElement.querySelector(".charCount");
    if (charCountSpan) {
        charCountSpan.textContent = `${input.value.length} / ${maxCount}`;
    }
};

const previewImage = (uploadBtnImg, chosenImg) => {
    const file = uploadBtnImg.files[0];
    if (!file) {
        chosenImg.removeAttribute("src");
        chosenImg.removeAttribute("alt");
        return;
    }
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
        chosenImg.setAttribute("src", reader.result);
    };
    URL.revokeObjectURL(fileURL);
};

const previewPDF = (uploadBtnPDF, showBtnPDF) => {
    // console.log(uploadBtnPDF.files[0]);

    const file = uploadBtnPDF.files[0];
    if (!file) {
        showBtnPDF.classList.add("hidden");
        return;
    }
    showBtnPDF.classList.remove("hidden");
    showBtnPDF.onclick = () => {
        const fileURL = URL.createObjectURL(file);
        window.open(fileURL, "_blank");
        URL.revokeObjectURL(fileURL);
    };
};

const downloadUploadedFile = (uploadBtnExcel, showBtnDownload) => {
    // const fileInput = document.getElementById("awb_pod");
    const file = uploadBtnExcel.files[0];

    if (!file) {
        showBtnDownload.classList.add("hidden");
        return;
    }
    showBtnDownload.classList.remove("hidden");
    showBtnDownload.onclick = () => {
        const fileURL = URL.createObjectURL(file);
        const a = document.createElement("a");
        a.href = fileURL;
        a.download = file.name;
        a.click();
        URL.revokeObjectURL(fileURL);
    };
};
