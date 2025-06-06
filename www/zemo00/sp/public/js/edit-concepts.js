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
    $('.concept-search').each(function () {
        const $select = $(this);
        const preselectedId = $select.data('selected-id');
        const preselectedText = $select.data('selected-text');

        if (preselectedId && preselectedText) {
            const option = new Option(preselectedText, preselectedId, true, true);
            $select.append(option).trigger('change');
        }

        initConceptSelect2($select);
    });
});

function removeConcept(button) {
    const entries = document.querySelectorAll('#concept-fields .concept-entry');
    if (entries.length <= 1) {
        alert("At least one concept is required.");
        return;
    }

    button.closest('.concept-entry').remove();
}