let alert = document.getElementById('cartAlert');

document.addEventListener('click', function(e) {
  const button = e.target.closest('.addToCart button');
  if (button) {
    e.preventDefault();

    const form = button.closest('form');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(res => res.json())
        .then(data => {
            let text, type;
            if (data && data.login) {
                window.location.href = './login.php';
                return;
            }
            else if (data === true) {
                text = "Product was successfully added to the cart.";
                type = "success";
            } else {
                text = "Failed to add the product to the cart.";
                type = "danger";
            }
            window.scrollTo(0, 0);
            toggleAlert(text, type);
            setTimeout(() => toggleAlert('', type), 4000);
        });
  }
});

function toggleAlert(text, type) {
    alert.innerHTML = text;
    alert.classList.remove('alert-success', 'alert-danger');
    alert.classList.add('alert-' + type);
    if (text) {
        alert.style.display = "block";
    } else {
        alert.style.display = "none";
    }
}