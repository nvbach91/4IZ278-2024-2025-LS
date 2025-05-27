let selectedSlotId = null;
let selectedTimeSlot = null;

document.addEventListener("DOMContentLoaded", function () {
    const datePicker = document.getElementById("datePicker");
    const container = document.getElementById("timeslotContainer");

    if (!datePicker || !container) return;

    const serviceId = datePicker.dataset.serviceId;

    // Load saved date from localStorage
    const savedDate = localStorage.getItem(`selectedDate-${serviceId}`);
    if (savedDate) {
        datePicker.value = savedDate;
        loadTimeSlots(savedDate);
    }

    datePicker.addEventListener("change", function () {
        const selectedDate = datePicker.value;
        if (!selectedDate) return;

        // Save selected date to localStorage
        localStorage.setItem(`selectedDate-${serviceId}`, selectedDate);

        loadTimeSlots(selectedDate);
    });

    function loadTimeSlots(date) {
        fetch(`${BASE_URL}/api/service/${serviceId}/timeslots?date=${date}`)
            .then((response) => {
                if (!response.ok)
                    throw new Error("Network response was not ok");
                return response.json();
            })
            .then((data) => {
                container.innerHTML =
                    data.html ||
                    '<p class="text-muted">Žádné dostupné časy pro tento den.</p>';

                // Attach click listeners to timeslot buttons
                document
                    .querySelectorAll(".timeslot-btn:not(.disabled)")
                    .forEach((button) => {
                        button.addEventListener("click", () => {
                            const isSelected =
                                button.classList.contains("btn-primary");

                            // Deselect all buttons
                            document
                                .querySelectorAll(".timeslot-btn")
                                .forEach((btn) => {
                                    btn.classList.remove("btn-primary");
                                    btn.classList.add("btn-outline-primary");
                                });

                            // Toggle selection
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
            })
            .catch((error) => {
                container.innerHTML =
                    '<p class="text-danger">Chyba při načítání slotů.</p>';
                console.error(error);
            });
    }
});

function confirmReservation() {
    const slotId = selectedSlotId;
    const serviceId = document.getElementById("datePicker").dataset.serviceId;
    const date = document.getElementById("datePicker").value;

    if (!slotId || !serviceId || !date) {
        showInlineError("Prosím vyberte datum a časový slot.");
        return;
    }

    const form = document.createElement("form");
    form.method = "POST";
    form.action = CONFIRM_RESERVATION_URL;

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    form.innerHTML = `
        <input type="hidden" name="_token" value="${csrf}">
        <input type="hidden" name="service_id" value="${serviceId}">
        <input type="hidden" name="slot_id" value="${slotId}">
        <input type="hidden" name="date" value="${date}">
    `;

    document.body.appendChild(form);
    form.submit();
}
