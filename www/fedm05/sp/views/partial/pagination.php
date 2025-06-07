<?php if ($pagination['totalPages'] > 1): ?>
    <div class="pagination">
        <div class="pagination-controls">
            <!-- show all pages -->
            <?php for ($i = 1; $i <= $pagination['totalPages']; $i++): ?>
                    <a class="pagination-btn <?php echo $i == $pagination['currentPage'] ? "active" : '' ?>"
                    href="<?php echo $pagination['pageUrls'][$i]; ?>">
                        <?php echo $i; ?>
                    </a>
            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>