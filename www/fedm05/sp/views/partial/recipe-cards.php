<?php if (!empty($recipes)): ?>
    <?php foreach ($recipes as $recipe): ?>
        <a href="./recipe-detail?id=<?php echo $recipe['id']; ?>" class="recipe-card-link">
            <div class="recipe-card">
                <button class="favorite-btn <?php echo isset($recipe['is_favorite']) && $recipe['is_favorite'] ? 'favorited' : ''; ?>"
                    data-recipe-id="<?php echo $recipe['id']; ?>"
                    data-action="<?php echo isset($recipe['is_favorite']) && $recipe['is_favorite'] ? 'remove' : 'add'; ?>"
                    onclick="event.preventDefault(); event.stopPropagation();">
                    <svg class="heart-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </button>
                <img src="<?php echo $recipe["img"]?>" alt="" width="100px" height="100px" class="recipe-image">
                <div class="recipe-content">
                    <div class="recipe-info">
                        <h3 class="recipe-title"><?php echo htmlspecialchars($recipe['name']); ?></h3>
                        <div class="recipe-meta">
                            <span class="recipe-difficulty"><?php echo htmlspecialchars($recipe['difficulty']); ?></span>
                            <span class="recipe-time"><?php echo htmlspecialchars($recipe['cooktime']); ?> min</span>
                        </div>
                        <div class="recipe-author">by <?php echo htmlspecialchars($recipe['owner_name']); ?></div>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <?php if ($pageTitle === "My Favourites"): ?>
        <div class="no-recipes">
            <p>You have no favorite recipes yet.</p>
        </div>
    <?php elseif ($pageTitle === "My Recipes"): ?>
        <div class="no-recipes">
            <p>You don't have any own recipes, you can try creating one.</p>
        </div>
    <?php else: ?>
        <div class="no-recipes">
            <p>No recipes found.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>