document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('addProductBtn').addEventListener('click', function() {
        document.getElementById('modal_product_id').value = '';
        document.getElementById('modal_product_name').value = '';
        document.getElementById('modal_product_description').value = '';
        document.getElementById('modal_product_detail').value = '';
        document.getElementById('modal_product_price').value = '';
        document.getElementById('modal_product_image').value = '';
        document.getElementById('modal_product_stock').value = '';
        document.getElementById('modal_product_min_age').value = '';
        document.getElementById('modal_product_max_age').value = '';
        document.getElementById('modal_product_tag').value = '';
        document.getElementById('modal_product_genre_id').selectedIndex = 0;
        document.getElementById('modal_product_category_id').selectedIndex = 0;
    });

    document.querySelectorAll('.edit-product-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('modal_product_id').value = btn.getAttribute('data-id') || '';
            document.getElementById('modal_product_name').value = btn.getAttribute('data-name') || '';
            document.getElementById('modal_product_description').value = btn.getAttribute('data-description') || '';
            document.getElementById('modal_product_detail').value = btn.getAttribute('data-detail') || '';
            document.getElementById('modal_product_price').value = btn.getAttribute('data-price') || '';
            document.getElementById('modal_product_image').value = btn.getAttribute('data-image') || '';
            document.getElementById('modal_product_stock').value = btn.getAttribute('data-stock') || '';
            document.getElementById('modal_product_min_age').value = btn.getAttribute('data-min_age') || '';
            document.getElementById('modal_product_max_age').value = btn.getAttribute('data-max_age') || '';
            document.getElementById('modal_product_tag').value = btn.getAttribute('data-tag') || '';
            document.getElementById('modal_product_genre_id').value = btn.getAttribute('data-genre_id') || '';
            document.getElementById('modal_product_category_id').value = btn.getAttribute('data-category_id') || '';
        });
    });
});
