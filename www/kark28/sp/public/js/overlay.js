document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('overlay');

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            closeOverlay();
        }
    });
});
 
function showOverlay() {
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'flex';
}

function closeOverlay() {
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'none';
}
