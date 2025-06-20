document.addEventListener("DOMContentLoaded", function () {
    let serviceIndex = window.initialServiceIndex || 0;

    const addBtn = document.getElementById("add-service-btn");
    const container = document.getElementById("new-services-container");

    if (addBtn && container) {
        addBtn.addEventListener("click", function () {
            const serviceHtml = `
                <div class="border p-3 mb-3">
                    <div class="mb-2">
                        <label class="form-label">Název služby</label>
                        <input type="text" name="services[${serviceIndex}][name]" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Popis služby</label>
                        <textarea name="services[${serviceIndex}][description]" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Doba trvání (minuty)</label>
                        <input type="number" name="services[${serviceIndex}][duration_minutes]" class="form-control" required min="1">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Cena (Kč)</label>
                        <input type="number" name="services[${serviceIndex}][price]" class="form-control" required min="0">
                    </div>
                </div>
            `;
            container.insertAdjacentHTML("beforeend", serviceHtml);
            serviceIndex++;
        });
    }
});
