function addConceptField() {
    const container = document.getElementById('concept-fields');
    const firstEntry = container.querySelector('.concept-entry');

    if (!firstEntry) return;

    const newEntry = firstEntry.cloneNode(true);

    const selects = newEntry.querySelectorAll('select');
    const inputs = newEntry.querySelectorAll('input');

    selects.forEach(select => {
        select.selectedIndex = 0;
    });

    inputs.forEach(input => {
        input.value = '';
    });

    container.appendChild(newEntry);
}

function removeConcept(button) {
    const container = document.getElementById('concept-fields');
    const entries = container.querySelectorAll('.concept-entry');

    if (entries.length > 1) {
        button.closest('.concept-entry').remove();
    } else {
        alert("At least one concept is required.");
    }
}