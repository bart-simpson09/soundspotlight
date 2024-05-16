const photoInput = document.getElementById("photoInput");
const titleInput = document.getElementById("albumTitle");
const authorInput = document.getElementById("authorName");
const languageInput = document.getElementById("language");
const categoryInput = document.getElementById("category");
const releaseDateInput = document.getElementById("releaseDate");
const songsNumberInput = document.getElementById("songsNumber");
const descriptionInput = document.getElementById("description");
const photoPreview = document.getElementById("uploadedCoverPreview");
const submitButton = document.getElementById("submitButton");

submitButton.addEventListener('click', () => {
    validateForm();
})

function checkIfEmpty(event) {
    const input = event.target;

    if (input.value.trim() === "") {
        input.classList.add("inputError");
    } else {
        input.classList.remove("inputError");
    }
}

function validateForm() {
    const inputs = [photoInput, titleInput, authorInput, languageInput, categoryInput, releaseDateInput, songsNumberInput, descriptionInput];
    const allFilled = inputs.every(input => input.value.trim() !== "");

    if (!allFilled) {
        inputs.forEach(input => {
            if (input.value.trim() === "") {
                input.classList.add('inputError');
            }
        });
    }

    if (photoInput.value.trim() === "") {
        photoPreview.style.borderColor = 'var(--color-red-100)';
    } else {
        photoPreview.style.borderColor = 'var(--color-grey-30)';
    }
}

function checkFileSize(event) {
    const file = event.target.files[0]; // Access the first selected file
    const fileSizeLimit = 1024 * 1024; // 1 Megabyte in bytes

    if (file && file.size > fileSizeLimit) {
        alert("File size is too large! Please choose a file under 1 MB.");
        photoInput.value = ""; // Clear the input value
        document.getElementById('uploadedCoverPreview').setAttribute('src', '/public/assets/imgs/covers/default-cover.png');
        return true;
    }

    return false;
}

const uploadCoverInput = document.querySelector("#photoInput");
const previewUploadedCover = () => {
    const file = uploadCoverInput.files[0]; // Access the first selected file
    if (file) {
        const fileReader = new FileReader();
        const preview = document.getElementById('uploadedCoverPreview');
        fileReader.onload = function (event) {
            preview.setAttribute('src', event.target.result);
            preview.style.borderColor = 'var(--color-grey-30)';
        }
        fileReader.readAsDataURL(file); // Pass the actual file object
    }
}

photoInput.addEventListener("change", checkFileSize);

uploadCoverInput.addEventListener("change", (event) => {
    if (!checkFileSize(event)) {
        previewUploadedCover();
    }
});

[photoInput, titleInput, authorInput, languageInput, categoryInput, releaseDateInput, songsNumberInput, descriptionInput].forEach(input => {
    input.addEventListener("blur", checkIfEmpty);
});
