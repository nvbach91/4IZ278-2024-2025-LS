const SERVER_NOW = new Date(window.SERVER_NOW);

document.addEventListener("DOMContentLoaded", () => {
    const datePicker = document.getElementById("datePicker");
    const timeslotContainer = document.getElementById("timeslotContainer");

    if (!datePicker || !timeslotContainer) return;

    const serviceId = datePicker.dataset.serviceId;

    async function fetchAvailableDates() {
        try {
            const response = await fetch(
                `${BASE_URL}/api/service/${serviceId}/available-dates`
            );
            if (!response.ok)
                throw new Error("Failed to fetch available dates");
            const data = await response.json();
            availableDates = data.dates || [];
            console.log("Available dates loaded:", availableDates);
        } catch (error) {
            console.error("Error loading available dates:", error);
            availableDates = [];
        }
    }

    function initDatePicker() {
        flatpickr(datePicker, {
            dateFormat: "Y-m-d",
            minDate: "today",
            locale: { firstDayOfWeek: 1 },
            onChange(selectedDates, dateStr) {
                if (!dateStr) return;
                localStorage.setItem(`selectedDate-${serviceId}`, dateStr);
                loadTimeSlots(dateStr);
            },
            onDayCreate(dObj, dStr, fp, dayElem) {
                const date =
                    dayElem.dateObj.getFullYear() +
                    "-" +
                    String(dayElem.dateObj.getMonth() + 1).padStart(2, "0") +
                    "-" +
                    String(dayElem.dateObj.getDate()).padStart(2, "0");
                if (availableDates.includes(date)) {
                    const dot = document.createElement("div");
                    dot.classList.add("availability-dot");
                    dayElem.appendChild(dot);
                }
            },
        });

        const savedDate = localStorage.getItem(`selectedDate-${serviceId}`);
        if (savedDate) {
            datePicker._flatpickr.setDate(savedDate);
            loadTimeSlots(savedDate);
        }
    }

    async function loadTimeSlots(date) {
        try {
            const response = await fetch(
                `${BASE_URL}/api/service/${serviceId}/timeslots?date=${date}`
            );
            if (!response.ok) throw new Error("Failed to load timeslots");

            const data = await response.json();

            timeslotContainer.innerHTML =
                data.html ||
                '<p class="text-muted">Žádné dostupné časy pro tento den.</p>';

            attachTimeslotListeners();
        } catch (error) {
            timeslotContainer.innerHTML =
                '<p class="text-danger">Chyba při načítání slotů.</p>';
            console.error(error);
        }
    }

    function attachTimeslotListeners() {
        const buttons = timeslotContainer.querySelectorAll(".timeslot-btn");

        const nowMs = SERVER_NOW.getTime();
        const fiveMinutesLaterMs = nowMs + 5 * 60000;

        buttons.forEach((button) => {
            const datetimeStr = button.dataset.datetime;
            if (!datetimeStr) return;

            const slotTimeMs = new Date(button.dataset.datetime).getTime(); 

            if (slotTimeMs <= fiveMinutesLaterMs) {
                button.classList.remove("btn-outline-primary", "btn-primary");
                button.classList.add("btn-outline-secondary", "disabled", "text-muted");
                button.setAttribute("disabled", "true");
                return;
            }

            button.addEventListener("click", () => {
                const isSelected = button.classList.contains("btn-primary");

                buttons.forEach((btn) => {
                    btn.classList.remove("btn-primary");
                    btn.classList.add("btn-outline-primary");
                });

                if (!isSelected) {
                    button.classList.remove("btn-outline-primary");
                    button.classList.add("btn-primary");
                    selectedSlotId = button.dataset.slotId;
                    selectedTimeSlot = button.innerText;
                } else {
                    selectedSlotId = null;
                    selectedTimeSlot = null;
                }
            });
        });
    }

    (async () => {
        await fetchAvailableDates();
        initDatePicker();
    })();
});

// Function to confirm reservation by submitting form via POST
function confirmReservation() {
    const datePicker = document.getElementById("datePicker");
    const slotId = selectedSlotId;
    const serviceId = datePicker?.dataset.serviceId;
    const date = datePicker?.value;

    if (!slotId || !serviceId || !date) {
        showInlineError("Prosím vyberte datum a časový slot.");
        return;
    }

    const form = document.createElement("form");
    form.method = "POST";
    form.action = CONFIRM_RESERVATION_URL;

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    form.innerHTML = `
        <input type="hidden" name="_token" value="${csrfToken}">
        <input type="hidden" name="service_id" value="${serviceId}">
        <input type="hidden" name="slot_id" value="${slotId}">
        <input type="hidden" name="date" value="${date}">
    `;

    document.body.appendChild(form);
    form.submit();
}
