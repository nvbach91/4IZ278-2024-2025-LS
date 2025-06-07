const selectedTableBody = document.querySelector('#selected-words-table tbody');
const selectedMap = new Map();

const currentLang = new URLSearchParams(window.location.search).get('lang');

const savedLang = sessionStorage.getItem('selectedLang');
const savedWords = sessionStorage.getItem('selectedWords');

if (savedLang === currentLang && savedWords) {
    const parsed = JSON.parse(savedWords);
    for (const id in parsed) {
        selectedMap.set(id, parsed[id]);
    }
    updateSelectedTable();
} else {
    sessionStorage.removeItem('selectedWords');
    sessionStorage.setItem('selectedLang', currentLang); // update stored lang
}

document.querySelectorAll('.add-word-btn').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.dataset.id;
        const word = button.dataset.word;
        const lang = button.dataset.lang;

        if (selectedMap.has(id)) return;

        selectedMap.set(id, { word, lang });
        persistAndUpdate();
    });
});

function persistAndUpdate() {
    sessionStorage.setItem('selectedWords', JSON.stringify(Object.fromEntries(selectedMap)));
    sessionStorage.setItem('selectedLang', currentLang);
    updateSelectedTable();
}

function updateSelectedTable() {
    selectedTableBody.innerHTML = '';
    selectedMap.forEach((data, id) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${data.word}</td>
            <td>${data.lang}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-btn" data-id="${id}">Remove</button>
                <input type="hidden" name="word_ids[]" value="${id}">
            </td>
        `;
        selectedTableBody.appendChild(row);
    });

    selectedTableBody.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            selectedMap.delete(id);
            persistAndUpdate();
        });
    });
}

document.querySelector('form').addEventListener('submit', () => {
    sessionStorage.removeItem('selectedWords');
    sessionStorage.removeItem('selectedLang');
});