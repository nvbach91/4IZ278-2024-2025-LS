<?php require_once __DIR__ . '/prefix.php'; ?>
<form method="GET" action="index.php">
    <!-- Categories -->
    <p class="form-label">Categories:</p>
    <button class="btn btn-primary" type="button" id="categoryButton" onclick="toggleCategoriesDropdown()">Show categories</button>
    <div class="dropdown" id="categoryDropdown">    
        <div class="form-check">
            <input type="checkbox" name="category[]" class="form-check-label" id="checkDefault" value="0" <?php echo in_array('0',$categoriesWeb) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="checkDefault">All categories</label>
        </div>
        <?php foreach ($categories as $category): ?>
            <div class="form-check">
                <input type="checkbox" name="category[]" class="form-check-label" id="checkDefault" value="<?php echo $category['category_id'];?>" <?php echo (in_array($category['category_id'], $categoriesWeb)&&!(in_array('0', $categoriesWeb))) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="checkDefault"><?php echo $category['name'];?></label>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Playtime -->
    <div class="input-group mb-3">
        <label for="max-playtime" class="form-label">Max playtime:</label>
        <input type="range" class="form-range" id="max-playtime" min="<?php echo $minPlaytime; ?>" max="<?php echo $maxPlaytime; ?>" 
            value="<?php echo $maxPlaytimeWeb; ?>" oninput="this.nextElementSibling.value = this.value" step="1">
        <input type="number" class="form-control" name="max-playtime" id="max-playtime" min="<?php echo $minPlaytime; ?>" max="<?php echo $maxPlaytime; ?>" 
            value="<?php echo $maxPlaytimeWeb; ?>" oninput="this.previousElementSibling.value = this.value" >
        <span class="input-group-text">minutes</span>
    </div>

    <!-- Players -->
    <div class="input-group mb-3">
        <label for="min-players" class="form-label">Min players:</label>
        <input type="range" class="form-range" id="min-players" min="<?php echo $minPlayers; ?>" max="<?php echo $maxPlayers; ?>" 
            value="<?php echo $minPlayersWeb; ?>" oninput="this.nextElementSibling.value = this.value" step="1">
        <input type="number" name="min-players" class="form-control" id="min-players" min="<?php echo $minPlayers; ?>" max="<?php echo $maxPlayers; ?>" 
            value="<?php echo $minPlayersWeb; ?>" oninput="this.previousElementSibling.value = this.value" >
        <span class="input-group-text">players</span>
    </div>
    <div class="input-group mb-3">
        <label for="max-players" class="form-label">Max players:</label>
        <input type="range" class="form-range" id="max-players" min="<?php echo $minPlayers; ?>" max="<?php echo $maxPlayers; ?>" 
            value="<?php echo $maxPlayersWeb; ?>" oninput="this.nextElementSibling.value = this.value" step="1">
        <input type="number" class="form-control" name="max-players" id="max-players" min="<?php echo $minPlayers; ?>" max="<?php echo $maxPlayers; ?>" 
            value="<?php echo $maxPlayersWeb; ?>" oninput="this.previousElementSibling.value = this.value" >
        <span class="input-group-text">players</span>
    </div>

    <div class="d-flex gap-2 flex-wrap justify-content-center">
        <!-- Buttons -->
        <button type="submit" class="btn btn-primary">
            <span class="material-symbols-outlined align-middle">filter_alt</span>
            Apply filter
        </button>
        <a href="<?php echo $urlPrefix ?>/index.php" class="btn btn-secondary">
            <span class="material-symbols-outlined align-middle">filter_alt_off</span>
            Reset filter
        </a>
    </div>
</form>