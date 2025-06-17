document.addEventListener("DOMContentLoaded", function() {
    var addressModal = document.getElementById('addressModal');
    addressModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('modal_order_id').value = button.getAttribute('data-order-id') || '';
        document.getElementById('modal_shipping_name').value = button.getAttribute('data-shipping-name') || '';
        document.getElementById('modal_shipping_street').value = button.getAttribute('data-shipping-street') || '';
        document.getElementById('modal_shipping_city').value = button.getAttribute('data-shipping-city') || '';
        document.getElementById('modal_shipping_postal_code').value = button.getAttribute('data-shipping-postal_code') || '';
        document.getElementById('modal_shipping_email').value = button.getAttribute('data-shipping-email') || '';
        document.getElementById('modal_shipping_phone').value = button.getAttribute('data-shipping-phone') || '';
    });
});
