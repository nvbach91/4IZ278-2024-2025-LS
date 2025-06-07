const BASE_URL = "<?php echo BASE_URL; ?>";
function addExistingConcept() {
    const container = document.getElementById('existing-concepts');
    const first = container.querySelector('.concept-entry.existing');
    if (!first) return;

    const clone = first.cloneNode(true);
    const select = clone.querySelector('select');

    select.innerHTML = '';
    select.classList.add('concept-search');

    container.appendChild(clone);

    initConceptSelect2(select);
}

function addNewConcept() {
    const container = document.getElementById('new-concepts');

    const newEntry = document.createElement('div');
    newEntry.className = 'concept-entry new border rounded p-3 mb-3';

    newEntry.innerHTML = `
        <div class="mb-2">
            <label class="form-label">New concept name</label>
            <input type="text" name="concepts[]" class="form-control" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Description (optional)</label>
            <input type="text" name="descriptions[]" class="form-control">
        </div>
        <input type="hidden" name="existing_concepts[]" value="">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeConcept(this)">Remove</button>
    `;

    container.appendChild(newEntry);
}

function removeConcept(button) {
    const existingEntries = document.querySelectorAll('#existing-concepts .concept-entry').length;
    const newEntries = document.querySelectorAll('#new-concepts .concept-entry').length;

    if (existingEntries + newEntries <= 1) {
        alert("At least one concept is required.");
        return;
    }

    button.closest('.concept-entry').remove();
}

function initConceptSelect2(selector) {
    $(selector).select2({
        placeholder: "Search for a concept",
        ajax: {
            url: "https://eso.vse.cz/~zemo00/sp/public/api/search_concepts.php",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        },
        width: '100%'
    });
}

$(document).ready(function () {
    initConceptSelect2('.concept-search');
});