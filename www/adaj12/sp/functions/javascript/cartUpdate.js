document.addEventListener('DOMContentLoaded', function() {
    const AJAX_URL = '/~adaj12/test/functions/php/cartUpdate.php';

    // AJAX změna počtu kusů
    document.querySelectorAll('.cart-qty-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const id = this.dataset.id;
            const value = this.value;
            fetch(AJAX_URL, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'quantity[' + id + ']=' + encodeURIComponent(value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    document.getElementById('subtotal-' + id).innerText = data.itemSubtotal + ' Kč';
                    document.getElementById('cart-total').innerText = data.total + ' Kč';
                }
            });
        });
    });

    // AJAX odebrání položky
    document.querySelectorAll('.cart-remove-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(AJAX_URL, {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'remove=' + encodeURIComponent(id)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    const row = document.getElementById('cart-row-' + id);
                    if (row) row.remove();
                    document.getElementById('cart-total').innerText = data.total + ' Kč';
                    if (data.empty) {
                        let table = document.getElementById('cart-table');
                        if (table) table.style.display = 'none';
                        document.getElementById('cart-empty-info').style.display = 'block';
                    }
                }
            });
        });
    });

    // MODÁL - popup při pokusu o objednávku nepřihlášeným uživatelem
    var orderBtn = document.getElementById('order-btn');
    if (orderBtn) {
        orderBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var loginModalEl = document.getElementById('loginModal');
            if (window.bootstrap && loginModalEl) {
                var loginModal = new bootstrap.Modal(loginModalEl);
                loginModal.show();
            } else {
                alert('Pro dokončení objednávky se přihlaste nebo registrujte.');
            }
        });
    }
});
