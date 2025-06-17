@extends('layouts.app')

@section('content')
    @php
        $editRole = $business->canEdit($currentUser);
    @endphp

    <div class="w-100 px-3 mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none">
            <i class="fas fa-chevron-left"></i> Zpět
        </a>
    </div>

    <div class="container mt-4">
        <h1>Upravit firmu</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('business.update', $business->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mt-3">

                <!-- levý sloupec: služby -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Služby</h5>

                            @if ($business->services->isEmpty())
                                <p class="text-muted">Žádné služby zatím nejsou definovány.</p>
                            @else
                                @foreach ($business->services as $index => $service)
                                    <div class="existing-service border p-3 mb-3 position-relative">
                                        <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">
                                        <input type="hidden" name="services[{{ $index }}][delete]" value="0" class="delete-flag">

                                        <div class="mb-2">
                                            <label class="form-label">Název služby</label>
                                            <input type="text" name="services[{{ $index }}][name]"
                                                   class="form-control"
                                                   value="{{ $service->name }}"
                                                   required>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Popis služby</label>
                                            <textarea name="services[{{ $index }}][description]"
                                                      class="form-control"
                                                      rows="2">{{ $service->description }}</textarea>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Doba trvání (minuty)</label>
                                            <input type="number" name="services[{{ $index }}][duration_minutes]"
                                                   class="form-control"
                                                   min="5" step="5"
                                                   value="{{ $service->duration_minutes }}"
                                                   required>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Cena (Kč)</label>
                                            <input type="number" name="services[{{ $index }}][price]"
                                                   class="form-control"
                                                   min="0"
                                                   value="{{ $service->price }}"
                                                   required>
                                        </div>

                                        <button type="button"
                                                class="btn-close position-absolute top-0 end-0 m-2 remove-existing-service-btn"
                                                aria-label="Odstranit"></button>
                                    </div>
                                @endforeach
                            @endif

                            <div class="mb-3">
                                <button type="button"
                                        class="btn btn-outline-primary w-100"
                                        id="add-service-btn">
                                    + Přidat novou službu
                                </button>
                            </div>

                            <div id="new-services-container"></div>
                        </div>
                    </div>
                </div>

                <!-- pravý sloupec: informace o firmě -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Informace o firmě</h5>

                            <div class="mb-3">
                                <label for="name" class="form-label">Název firmy</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control"
                                       value="{{ old('name', $business->name) }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Popis</label>
                                <textarea name="description"
                                          id="description"
                                          class="form-control"
                                          rows="4">{{ old('description', $business->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- pravý sloupec: tým -->
                    @if($editRole === 'owner')
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Tým</h5>

                            <ul class="list-group mb-3"
                                id="manager-list"
                                data-roles='@json($roles)'>
                                @foreach ($business->business_managers as $index => $manager)
                                    @if($manager->permission_level === 'owner')
                                        @continue
                                    @endif
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap bg-light existing-manager">
                                        <div class="flex-grow-1 me-2">
                                            <div class="mb-2">
                                                <label class="form-label mb-1">Email</label>
                                                <input type="email"
                                                       class="form-control form-control-sm"
                                                       value="{{ $manager->user->email }}"
                                                       disabled>
                                            </div>
                                            <div>
                                                <label class="form-label mb-1">Role / Oprávnění</label>
                                                <select name="managers[{{ $index }}][permission_level]"
                                                        class="form-select form-select-sm">
                                                    @foreach ($roles as $value => $label)
                                                        <option value="{{ $value }}"
                                                            {{ $manager->permission_level === $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column align-items-end">
                                            <input type="hidden"
                                                   name="managers[{{ $index }}][id]"
                                                   value="{{ $manager->id }}">
                                            <input type="hidden"
                                                   name="managers[{{ $index }}][delete]"
                                                   value="0"
                                                   class="delete-flag">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger mt-2 remove-existing-manager-btn">
                                                Odstranit
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="input-group mb-3">
                                <input type="email"
                                       class="form-control"
                                       id="new-manager-email"
                                       placeholder="E-mail nového manažera">
                                <select class="form-select form-select-sm"
                                        id="new-manager-role">
                                    @foreach ($roles as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="button"
                                        class="btn btn-outline-primary"
                                        id="add-manager-btn">
                                    Přidat
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Tlačítka -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('business.show', $business->id) }}" class="btn btn-secondary">Zrušit</a>
                <button type="submit" class="btn btn-success">Uložit změny</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    //
    // 1) PŘIDÁVÁNÍ NOVÝCH SLUŽEB
    //
    const svcContainer  = document.getElementById('new-services-container');
    const addSvcBtn     = document.getElementById('add-service-btn');
    // spočítáme, kolik už existujících služeb tu je
    let svcIndex = document.querySelectorAll('.existing-service').length;

    addSvcBtn.addEventListener('click', function() {
        // HTML šablona jednoho bloku nové služby
        const html = `
        <div class="existing-service border p-3 mb-3 position-relative">
          <input type="hidden" name="services[${svcIndex}][delete]" value="0" class="delete-flag">
          <div class="mb-2">
            <label class="form-label">Název služby</label>
            <input type="text" name="services[${svcIndex}][name]"
                   class="form-control" value="" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Popis služby</label>
            <textarea name="services[${svcIndex}][description]"
                      class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-2">
            <label class="form-label">Doba trvání (minuty)</label>
            <input type="number"
                   name="services[${svcIndex}][duration_minutes]"
                   class="form-control"
                   min="5" step="5"
                   value="" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Cena (Kč)</label>
            <input type="number" name="services[${svcIndex}][price]"
                   class="form-control"
                   min="0"
                   value="" required>
          </div>
          <button type="button"
                  class="btn-close position-absolute top-0 end-0 m-2 remove-new-service-btn"
                  aria-label="Odstranit"></button>
        </div>`.trim();

        // Vložíme před stávající kontejner
        svcContainer.insertAdjacentHTML('beforeend', html);

        svcIndex++;
    });

    // Delegace pro mazání nových služeb
    svcContainer.addEventListener('click', function(e) {
        if (!e.target.classList.contains('remove-new-service-btn')) return;
        const block = e.target.closest('.existing-service');
        block.remove();
    });

    //
    // 2) SPRÁVA MANAŽERŮ (jak už máš)
    //
    const mgrList    = document.getElementById('manager-list');
    const roles      = JSON.parse(mgrList.dataset.roles);
    const emailInput = document.getElementById('new-manager-email');
    const roleSelect = document.getElementById('new-manager-role');
    let mgrIndex     = mgrList.querySelectorAll('li').length;

    document.getElementById('add-manager-btn').addEventListener('click', function() {
        const email = emailInput.value.trim();
        const role  = roleSelect.value;
        if (!email) {
            alert('Zadejte prosím e-mail.');
            return;
        }

        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center flex-wrap bg-light existing-manager';
        li.innerHTML = `
            <div class="flex-grow-1 me-2">
              <div class="mb-2">
                <label class="form-label mb-1">Email</label>
                <input type="email" class="form-control form-control-sm" value="${email}" disabled>
              </div>
              <div>
                <label class="form-label mb-1">Role / Oprávnění</label>
                <select name="new_managers[${mgrIndex}][permission_level]" class="form-select form-select-sm">
                  ${Object.entries(roles).map(([val, lab]) =>
                    `<option value="${val}" ${val === role ? 'selected':''}>${lab}</option>`
                  ).join('')}
                </select>
              </div>
            </div>
            <div class="d-flex flex-column align-items-end">
              <input type="hidden" name="new_managers[${mgrIndex}][email]" value="${email}">
              <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-existing-manager-btn">Odebrat</button>
            </div>
        `;
        mgrList.appendChild(li);
        mgrIndex++;
        emailInput.value = '';
        roleSelect.selectedIndex = 0;
    });

    mgrList.addEventListener('click', function(e) {
        if (!e.target.classList.contains('remove-existing-manager-btn')) return;
        const li = e.target.closest('li');
        const delInput = li.querySelector('.delete-flag');
        if (delInput) {
            delInput.value = '1';
            li.classList.add('d-none');
        } else {
            li.remove();
        }
    });
});
</script>
@endpush
