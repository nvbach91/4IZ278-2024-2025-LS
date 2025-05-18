/**
 * Admin Seating Plan JavaScript
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin seating plan script initialized');
    
    // Store selected seats in an array
    let selectedSeats = [];
    
    // Cache DOM elements
    const selectedCountElement = document.getElementById('selected-count');
    const selectedSeatsInput = document.getElementById('selected_seats');
    const updateButton = document.getElementById('update_multiple_seats');
    const clearButton = document.getElementById('clear-selection');
    
    // Update UI elements
    function updateUI() {
        // Update selected count
        if (selectedCountElement) {
            selectedCountElement.textContent = selectedSeats.length;
        }
        
        // Update hidden input
        if (selectedSeatsInput) {
            selectedSeatsInput.value = selectedSeats.join(',');
            console.log(`Updated selected seats: ${selectedSeatsInput.value}`);
        }
        
        // Enable/disable update button
        if (updateButton) {
            updateButton.disabled = selectedSeats.length === 0;
        }
    }
    
    // Handle seat click
    function handleSeatClick(event) {
        event.preventDefault();
        event.stopPropagation();
        
        const seat = event.currentTarget;
        const row = seat.getAttribute('data-row');
        const col = seat.getAttribute('data-col');
        
        if (!row || !col) {
            console.warn("Missing row or column data for seat");
            return;
        }
        
        const seatKey = `${row}-${col}`;
        console.log("Seat clicked: " + seatKey);
        
        // Toggle the selected class
        seat.classList.toggle('selected');
        
        // Update selected seats list
        if (seat.classList.contains('selected')) {
            if (!selectedSeats.includes(seatKey)) {
                selectedSeats.push(seatKey);
                console.log("Added seat: " + seatKey);
            }
        } else {
            selectedSeats = selectedSeats.filter(s => s !== seatKey);
            console.log("Removed seat: " + seatKey);
        }
        
        // Update UI
        updateUI();
    }
    
    // Clear selection
    function clearSelection() {
        console.log("Clearing selection");
        document.querySelectorAll('.seat.selected').forEach(seat => {
            seat.classList.remove('selected');
        });
        selectedSeats = [];
        updateUI();
    }
    
    // Initialize
    function initialize() {
        console.log('Initializing admin seating plan');
        
        // Add click handlers to all seats
        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', handleSeatClick);
        });
        
        // Setup clear button
        if (clearButton) {
            clearButton.addEventListener('click', function(e) {
                e.preventDefault();
                clearSelection();
            });
        }
        
        // Setup form submission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (selectedSeats.length === 0 && this.querySelector('button[name="update_multiple_seats"]')) {
                    e.preventDefault();
                    alert('Please select at least one seat to update.');
                    return false;
                }
                return true;
            });
        }
        
        // Initial UI update
        updateUI();
    }
    
    // Initialize immediately
    initialize();
}); 