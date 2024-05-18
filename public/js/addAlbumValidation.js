// Selecting input elements
const inputs = {
    photo: document.getElementById("photoInput"),
    title: document.getElementById("albumTitle"),
    author: document.getElementById("authorName"),
    language: document.getElementById("language"),
    category: document.getElementById("category"),
    releaseDate: document.getElementById("releaseDate"),
    songsNumber: document.getElementById("songsNumber"),
    description: document.getElementById("description")
};

const photoPreview = document.getElementById("uploadedCoverPreview");
const submitButton = document.getElementById("submitButton");
const fileSizeLimit = 1024 * 1024; // 1 Megabyte in bytes

// Event Listeners
submitButton.addEventListener('click', validateForm);

Object.values(inputs).forEach(input => {
    input.addEventListener("blur", checkIfEmpty);
});

inputs.photo.addEventListener("change", handlePhotoChange);

// Event Handler Functions
function handlePhotoChange(event) {
    if (!checkFileSize(event)) {
        previewUploadedCover();
    }
}

function checkIfEmpty(event) {
    const input = event.target;
    toggleErrorClass(input, input.value.trim() === "");
}

function validateForm() {

    Object.values(inputs).forEach(input => {
        toggleErrorClass(input, input.value.trim() === "");
    });

    toggleBorderColor(photoPreview, inputs.photo.value.trim() === "");
}

function checkFileSize(event) {
    const file = event.target.files[0];
    if (file && file.size > fileSizeLimit) {
        alert("File size is too large! Please choose a file under 1 MB.");
        inputs.photo.value = "";
        resetPhotoPreview();
        return true;
    }
    return false;
}

function previewUploadedCover() {
    const file = inputs.photo.files[0];
    if (file) {
        const fileReader = new FileReader();
        fileReader.onload = function (event) {
            photoPreview.setAttribute('src', event.target.result);
            toggleBorderColor(photoPreview, false);
        }
        fileReader.readAsDataURL(file);
    }
}

// Helper Functions
function toggleErrorClass(input, isError) {
    if (isError) {
        input.classList.add("inputError");
    } else {
        input.classList.remove("inputError");
    }
}

function toggleBorderColor(element, isError) {
    element.style.borderColor = isError ? 'var(--color-red-100)' : 'var(--color-grey-30)';
}

function resetPhotoPreview() {
    photoPreview.setAttribute('src', '/public/assets/imgs/covers/default-cover.png');
    toggleBorderColor(photoPreview, true);
}
