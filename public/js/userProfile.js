const photoInput = document.getElementById("photoInput");
const form = document.getElementById("changeUserPhotoForm");

photoInput.addEventListener("change", checkFileSize);

function checkFileSize(event) {
    const file = event.target.files[0];
    const fileSizeLimit = 1024 * 1024;

    if (file && file.size > fileSizeLimit) {
        alert("File size is too large! Please choose a file under 1 MB.");
        photoInput.value = "";
    } else {
        form.submit();
    }
}