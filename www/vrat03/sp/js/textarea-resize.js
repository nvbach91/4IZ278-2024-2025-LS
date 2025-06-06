let textarea = document.getElementById("textarea");
textarea.addEventListener('input', autoResize, false);

function autoResize() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
}

document.addEventListener('DOMContentLoaded', function () {
    autoResize.call(textarea);
});