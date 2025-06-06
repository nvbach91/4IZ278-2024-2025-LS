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

    // Function to release the lock with retry mechanism
    async function releaseLock(retryCount = 3, retryDelay = 500) {
        if (!window.EVENT_ID || !window.HAS_SEAT_PLAN) return true;

        const formData = {
            csrf_token: window.CSRF_TOKEN,
            user_id: window.USER_ID
        };

        for (let i = 0; i < retryCount; i++) {
            try {
                const response = await fetch(`${window.SITE_URL}/admin/release_lock.php?event_id=${window.EVENT_ID}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        console.log('Lock released successfully');
                        return true;
                    }
                }

                const errorData = await response.json().catch(() => ({ error: 'Unknown error' }));
                console.error(`Failed to release lock (attempt ${i + 1}/${retryCount}):`, errorData.error);

                // Wait before retrying, with exponential backoff
                if (i < retryCount - 1) {
                    await new Promise(resolve => setTimeout(resolve, retryDelay * Math.pow(2, i)));
                }
            } catch (e) {
                console.error(`Error releasing lock (attempt ${i + 1}/${retryCount}):`, e);
                if (i < retryCount - 1) {
                    await new Promise(resolve => setTimeout(resolve, retryDelay * Math.pow(2, i)));
                }
            }
        }
        return false;
    }

    // Function to release lock synchronously (for beforeunload)
    function releaseLockSync() {
        if (!window.EVENT_ID || !window.HAS_SEAT_PLAN) return true;

        const formData = {
            csrf_token: window.CSRF_TOKEN,
            user_id: window.USER_ID
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', `${window.SITE_URL}/admin/release_lock.php?event_id=${window.EVENT_ID}`, false);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');

        try {
            xhr.send(JSON.stringify(formData));
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    return response.success === true;
                } catch (e) {
                    console.error('Failed to parse release lock response:', e);
                    return false;
                }
            }
            return false;
        } catch (e) {
            console.error('Failed to release lock synchronously:', e);
            return false;
        }
    }

    // Function to handle navigation after lock release
    async function handleNavigation(url = null) {
        // Skip lock release for create layout form
        if (!window.HAS_SEAT_PLAN || (event && event.target && event.target.closest('.create-layout-form'))) {
            if (url) {
                window.location.href = url;
            }
            return true;
        }

        const released = await releaseLock();
        if (released) {
            if (url) {
                window.location.href = url;
            }
            return true;
        } else {
            alert('Failed to release lock. Please try again or contact an administrator if the problem persists.');
            return false;
        }
    }

    // Keep the lock alive with periodic updates
    function keepLockAlive() {
        if (!window.EVENT_ID || !window.HAS_SEAT_PLAN) return;

        fetch(`${window.SITE_URL}/admin/seating_plan.php?event_id=${window.EVENT_ID}`, {
            method: 'HEAD',
            headers: {
                'X-CSRF-Token': window.CSRF_TOKEN
            }
        }).catch(error => {
            console.error('Failed to keep lock alive:', error);
            // If we fail to keep the lock alive, try to release it
            releaseLock().catch(console.error);
        });
    }

    // Add event listeners for lock handling
    function setupLockEventListeners() {
        // Handle all navigation links
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', async function(e) {
                if (!window.HAS_SEAT_PLAN || this.closest('.create-layout-form')) {
                    return true;
                }
                e.preventDefault();
                await handleNavigation(this.href);
            });
        });

        // Handle form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                if (!window.HAS_SEAT_PLAN || this.classList.contains('create-layout-form')) {
                    return true;
                }
                e.preventDefault();
                if (await handleNavigation()) {
                    this.submit();
                }
            });
        });

        // Handle browser back button
        window.addEventListener('popstate', async function(e) {
            if (!await handleNavigation()) {
                e.preventDefault();
                window.history.pushState(null, '', window.location.href);
            }
        });

        // Handle page visibility change
        document.addEventListener('visibilitychange', async function() {
            if (document.visibilityState === 'hidden') {
                await releaseLock();
            }
        });

        // Handle page unload
        window.addEventListener('beforeunload', function(e) {
            releaseLockSync();
        });

        // Keep the lock alive every 5 minutes
        const keepAliveInterval = setInterval(keepLockAlive, 5 * 60 * 1000);
        // Clear interval when page is unloaded
        window.addEventListener('unload', function() {
            clearInterval(keepAliveInterval);
        });
    }

    // Call setupLockEventListeners after DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupLockEventListeners);
    } else {
        setupLockEventListeners();
    }
}); 