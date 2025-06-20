function toggleCategoriesDropdown() {
    let categoriesList = document.getElementById("categoryDropdown");
    let button = document.getElementById("categoryButton");
    if (categoriesList.style.display == "block") {
        categoriesList.style.display = "none";
        button.innerHTML = "Show Categories";
    } else if (categoriesList.style.display == "none") {
        categoriesList.style.display = "block";
        button.innerHTML = "Hide Categories";
    }
}

onload = function () {
    document.getElementById("categoryDropdown").style.display = "none";
    document.getElementById("categoryButton").innerHTML = "Show Categories";
}
