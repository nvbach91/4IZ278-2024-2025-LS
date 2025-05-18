/**
 * Seating Plan JavaScript - Robust Implementation
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Seating plan script initialized');
    
    // Simple data storage
    let selectedSeats = [];
    
    // Cache DOM elements
    const selectedCountElement = document.getElementById('seat_count');
    const totalPriceElement = document.getElementById('total_price');
    const hiddenInput = document.getElementById('selected_seats');
    const checkoutButton = document.getElementById('checkout_button');
    const checkoutForm = document.getElementById('checkout_form');
    const selectionInfo = document.getElementById('selection-info');
    
    // Show selection info message
    if (selectionInfo) {
        selectionInfo.style.display = 'block';
    }
    
    // Update seat selection visuals
    function updateSeatVisuals() {
        document.querySelectorAll('.seat').forEach(seat => {
            const seatId = seat.getAttribute('data-seat-id');
            const isSelected = selectedSeats.some(s => s.id === seatId);
            
            // Apply or remove the selected class based on selection state
            if (isSelected) {
                seat.classList.add('selected');
            } else {
                seat.classList.remove('selected');
            }
        });
    }
    
    // Update all UI elements
    function updateUI() {
        // Update seat count
        if (selectedCountElement) {
            selectedCountElement.textContent = selectedSeats.length;
        }
        
        // Calculate and update total price
        let totalPrice = 0;
        selectedSeats.forEach(seat => {
            totalPrice += parseFloat(seat.price) || 0;
        });
        
        if (totalPriceElement) {
            totalPriceElement.textContent = totalPrice.toFixed(2) + ' CZK';
        }
        
        // Update hidden input for form submission
        if (hiddenInput) {
            hiddenInput.value = selectedSeats.map(seat => seat.id).join(',');
            console.log(`Updated hidden input to: ${hiddenInput.value}`);
        }
        
        // Enable/disable checkout button
        if (checkoutButton) {
            const hasSeats = selectedSeats.length > 0;
            checkoutButton.disabled = !hasSeats;
            
            if (hasSeats) {
                checkoutButton.classList.add('active');
            } else {
                checkoutButton.classList.remove('active');
            }
            
            console.log(`Checkout button is now ${hasSeats ? 'enabled' : 'disabled'}`);
        }
        
        // Update all seat visuals based on selection
        updateSeatVisuals();
    }
    
    // Handle seat click
    function handleSeatClick(event) {
        event.preventDefault();
        event.stopPropagation();
        
        const seat = event.currentTarget;
        
        // Only process free seats
        if (!seat.classList.contains('free')) {
            if (seat.classList.contains('user-reserved')) {
                alert('This seat is already in your cart.');
            }
            return;
        }
        
        const seatId = seat.getAttribute('data-seat-id');
        const seatPrice = parseFloat(seat.getAttribute('data-price') || 0);
        
        console.log(`Clicked on seat ${seatId} with price ${seatPrice}`);
        
        // Toggle selection state
        const index = selectedSeats.findIndex(s => s.id === seatId);
        
        if (index >= 0) {
            // Remove from selection
            selectedSeats.splice(index, 1);
            console.log(`Removed seat ${seatId} from selection`);
        } else {
            // Add to selection
            selectedSeats.push({
                id: seatId,
                price: seatPrice
            });
            console.log(`Added seat ${seatId} to selection`);
        }
        
        // Update UI
        updateUI();
    }
    
    // Initialize everything in the correct order
    function initialize() {
        console.log('Initializing seating plan');
        
        // Add click handlers to all seats
        document.querySelectorAll('.seat').forEach(seat => {
            seat.addEventListener('click', handleSeatClick);
        });
        
        // Setup checkout form
        if (checkoutForm) {
            console.log('Setting up checkout form');
            
            checkoutForm.addEventListener('submit', function(e) {
                // Prevent submission if no seats selected
                if (selectedSeats.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one seat before proceeding to checkout.');
                    return false;
                }
                
                // Ensure selected seats are in the form
                if (hiddenInput) {
                    hiddenInput.value = selectedSeats.map(seat => seat.id).join(',');
                }
                
                console.log(`Submitting form with seats: ${hiddenInput.value}`);
                return true;
            });
        }
        
        // Initial UI update
        updateUI();
    }
    
    // Initialize immediately
    initialize();
}); 