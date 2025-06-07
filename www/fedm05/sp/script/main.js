
document.addEventListener("DOMContentLoaded", function () {

    // portion calculator
    const portionController = document.querySelector(".portion-controller");

    if (portionController) {
        const decreaseBtn =
            portionController.querySelector(".portion-decrease");
        const increaseBtn =
            portionController.querySelector(".portion-increase");
        const portionValue = portionController.querySelector(".portion-value");
        const ingredientItems = document.querySelectorAll(".ingredient-item");

        const originalPortions = parseInt(portionValue.textContent);
        let currentPortions = originalPortions;

        function updateIngredientAmounts() {
            const multiplier = currentPortions / originalPortions;

            ingredientItems.forEach((item) => {
                const originalAmount = parseFloat(item.dataset.originalAmount);
                const unit = item.dataset.unit;
                const newAmount = originalAmount * multiplier;
                const displayAmount =
                    newAmount % 1 === 0
                        ? Math.round(newAmount)
                        : Math.round(newAmount * 10) / 10;

                const amountSpan = item.querySelector(".ingredient-amount");
                amountSpan.textContent = displayAmount + " " + unit;
            });
        }

        function updateButtonStates() {
            decreaseBtn.disabled = currentPortions <= 1;
            increaseBtn.disabled = currentPortions >= 30;
        }

        decreaseBtn.addEventListener("click", function () {
            if (currentPortions > 1) {
                currentPortions--;
                portionValue.textContent = currentPortions;
                updateIngredientAmounts();
                updateButtonStates();
            }
        });

        increaseBtn.addEventListener("click", function () {
            if (currentPortions < 20) {
                currentPortions++;
                portionValue.textContent = currentPortions;
                updateIngredientAmounts();
                updateButtonStates();
            }
        });
        updateButtonStates();
    }


    // Favorite button functionality
    document.querySelectorAll(".favorite-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const recipeId = this.dataset.recipeId;
            const action = this.dataset.action;

            fetch("./favorite-toggle", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `recipe_id=${recipeId}&action=${action}`,
            }).then((res) => {
                if (res.ok) {
                    this.dataset.action =
                        action === "add" ? "remove" : "add";
                    this.classList.toggle("favorited");
                } else{
                    window.location.href = "./login";
                }
            });
        });
    });
});

// add ingredient for form
function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const newIngredientItem = document.createElement('div');
    newIngredientItem.className = 'ingredient-item';
    
    newIngredientItem.innerHTML = `
        <input type="text" name="ingredient_amount[]" placeholder="1" class="ingredient-amount" required>
        <input type="text" name="ingredient_unit[]" placeholder="cup" class="ingredient-unit" required>
        <input type="text" name="ingredient_name[]" placeholder="Ingredient name" class="ingredient-name" required>
        <button type="button" onclick="removeIngredient(this)" class="remove-ingredient-btn">×</button>
    `;
    
    container.appendChild(newIngredientItem);
}

// remove ingredient from form
function removeIngredient(button) {
    const ingredientItem = button.parentElement;
    const container = document.getElementById('ingredients-container');
    
    if (container.children.length > 1) {
        ingredientItem.remove();
    }
}
// add ingredient for form
function addCategory() {
    const container = document.getElementById('category-container');
    const newCategoryItem = document.createElement('div');
    newCategoryItem.className = 'ingredient-item';
    
    newCategoryItem.innerHTML = `
        <input type="text" name="recipe_category_type[]" placeholder="Category type" class="ingredient-name" required>
        <input type="text" name="recipe_category_name[]" placeholder="Category name" class="ingredient-name" required>
        <button type="button" onclick="removeCategory(this)" class="remove-ingredient-btn">×</button>
    `;
    
    container.appendChild(newCategoryItem);
}

// remove ingredient from form
function removeCategory(button) {
    const categoryItem = button.parentElement;
    const container = document.getElementById('category-container');
    
    if (container.children.length > 1) {
        categoryItem.remove();
    }
}
