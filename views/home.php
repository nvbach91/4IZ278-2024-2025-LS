<!DOCTYPE html>
<?php
include __DIR__ . '/partial/head.php'
?>

<body>
    <div class="container">
        <!-- Header and navigation -->
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';
        ?> <!-- Featured Recipes Section -->
        <main class="featured-section">
            <h2>Featured Recipes</h2>
            <div class="recipes-grid">
                <?php
                include __DIR__ . '/partial/recipe-cards.php';
                ?>
            </div>
        </main>
        <!-- Footer -->
        <?php
        include __DIR__ . '/partial/footer.php';
        ?>
    </div>
    <script src="script/main.js"></script>
</body>

</html>