const langSelect = document.getElementById('lang');
const rows = document.querySelectorAll('tr[data-lang]');
const form = document.querySelector('form');

langSelect.addEventListener('change', () => {
    const selectedLang = langSelect.value;
    rows.forEach(row => {
        row.style.display = row.dataset.lang === selectedLang ? 'table-row' : 'none';
    });
});

form.addEventListener('submit', function (e) {
    const checked = document.querySelectorAll('input[name="word_ids[]"]:checked');
    if (checked.length < 5) {
        e.preventDefault();
        alert("Please select at least 5 words for the collection.");
    }
});

langSelect.dispatchEvent(new Event('change'));