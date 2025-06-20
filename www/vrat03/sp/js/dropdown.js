let categoriesList = document.getElementById("categoryDropdown");
let button = document.getElementById("categoryButton");

function toggleCategoriesDropdown() {
    if (categoriesList.style.display === "block") {
        categoriesList.style.display = "none";
        button.innerHTML = "<span class='material-symbols-outlined align-middle'>category</span>Show Categories";
    } else if (categoriesList.style.display == "none") {
        categoriesList.style.display = "block";
        button.innerHTML = "<span class='material-symbols-outlined align-middle'>category</span>Hide Categories";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    categoriesList.style.display = "none";
    button.innerHTML = "<span class='material-symbols-outlined align-middle'>category</span>Show Categories";
});
