document.addEventListener('DOMContentLoaded', function () {
    let serviceIndex = window.initialServiceIndex || 0;
    let managerIndex = 0;

    const addBtn = document.getElementById('add-service-btn');
    const container = document.getElementById('new-services-container');

    // Přidání nové služby
    if (addBtn && container) {
        addBtn.addEventListener('click', function () {
            const wrapper = document.createElement('div');
            wrapper.classList.add('border', 'p-3', 'mb-3', 'position-relative');

            wrapper.innerHTML = `
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-service-btn" aria-label="Odstranit"></button>

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
                    <input type="number" name="services[${serviceIndex}][duration_minutes]" class="form-control" required min="5" step="5">
                </div>

                <div class="mb-2">
                    <label class="form-label">Cena (Kč)</label>
                    <input type="number" name="services[${serviceIndex}][price]" class="form-control" required min="0">
                </div>
            `;

            container.appendChild(wrapper);
            serviceIndex++;
        });

        // Odstranění nové služby
        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-service-btn')) {
                e.target.closest('.border').remove();
            }
        });
    }

    // Odebrání existující služby (označení delete-flagem)
    document.querySelectorAll('.remove-existing-service-btn').forEach(button => {
        button.addEventListener('click', function () {
            const wrapper = button.closest('.existing-service');
            const deleteInput = wrapper.querySelector('.delete-flag');

            if (deleteInput.value === '0') {
                deleteInput.value = '1';
                wrapper.classList.add('opacity-50');
                button.textContent = 'Obnovit';
            } else {
                deleteInput.value = '0';
                wrapper.classList.remove('opacity-50');
                button.textContent = 'Odstranit';
            }
        });
    });

    // Přidání manažera
    const managerList = document.getElementById('manager-list');
    const addManagerBtn = document.getElementById('add-manager-btn');

    if (addManagerBtn && managerList) {
        addManagerBtn.addEventListener('click', function () {
            const emailInput = document.getElementById('new-manager-email');
            const email = emailInput.value.trim();

            if (!email) return;

            const item = document.createElement('li');
            item.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center', 'flex-wrap');
            item.innerHTML = `
                <div class="me-2">${email}</div>
                <div class="d-flex align-items-center">
                    <select name="new_managers[${managerIndex}][permission_level]" class="form-select form-select-sm me-2">
                        <option value="owner">Vlastník</option>
                        <option value="manager" selected>Manažer</option>
                        <option value="employee">Zaměstnanec</option>
                    </select>
                    <input type="hidden" name="new_managers[${managerIndex}][email]" value="${email}">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-manager-btn">Odebrat</button>
                </div>
            `;
            managerList.appendChild(item);
            emailInput.value = '';
            managerIndex++;
        });

        // Odebrání manažera
        managerList.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-manager-btn')) {
                const li = e.target.closest('li');
                const deleteFlag = li.querySelector('.delete-flag');
                if (deleteFlag) {
                    deleteFlag.value = '1';
                    li.classList.add('opacity-50');
                    e.target.textContent = 'Obnovit';
                } else {
                    li.remove();
                }
            }
        });
    }
});
