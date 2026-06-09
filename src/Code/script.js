// Run after the page loads
document.addEventListener('DOMContentLoaded', function() {

    // Handle add event form
    var eventForm = document.getElementById('event-form');
    if (eventForm) {
        eventForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var title = document.getElementById('title').value.trim();
            var date = document.getElementById('date').value.trim();
            var location = document.getElementById('location').value.trim();
            var description = document.getElementById('description').value.trim();

            if (title === '' || date === '' || location === '' || description === '') {
                showError('Please fill in all fields before submitting.');
                return;
            }

            var selectedDate = new Date(date);
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                showError('Please select a future date for the event.');
                return;
            }

            var formData = new FormData(this);
            // Fetch API - Reference: MDN (2024) https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API

            fetch('/php/add_event.php', {
                    method: 'POST',
                    body: formData
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        showSuccess('Event added successfully!');
                        eventForm.reset();
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showError('Error: ' + data.message);
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    showError('There was a network issue. Please try again.');
                });
        });
    }

    // Handle delete buttons
    var deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var eventId = this.getAttribute('data-id');
            if (!confirm('Are you sure you want to delete this event?')) {
                return;
            }
            fetch('/php/delete_event.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + eventId
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting event.');
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                });
        });
    });

    // Handle search and filter
    var searchInput = document.getElementById('search-input');
    var categoryFilter = document.getElementById('category-filter');

    if (searchInput && categoryFilter) {
        searchInput.addEventListener('keyup', function() {
            searchEvents();
        });
        categoryFilter.addEventListener('change', function() {
            searchEvents();
        });
    }

    // Handle category clicks in aside
    var categoryLinks = document.querySelectorAll('.category-item');
    categoryLinks.forEach(function(item) {
        item.addEventListener('click', function() {
            var category = this.getAttribute('data-category');
            var categoryFilterEl = document.getElementById('category-filter');
            var searchInputEl = document.getElementById('search-input');
            if (categoryFilterEl && searchInputEl) {
                categoryFilterEl.value = category;
                searchInputEl.value = '';
                // Reset location filter
                currentLocation = '';
                document.querySelectorAll('.location-item').forEach(function(li) {
                    li.classList.remove('active-filter');
                });
                searchEvents();
                document.getElementById('events-container').scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Handle location clicks in aside
    var locationLinks = document.querySelectorAll('.location-item');
    locationLinks.forEach(function(item) {
        item.addEventListener('click', function() {
            // Remove active from all
            locationLinks.forEach(function(li) {
                li.classList.remove('active-filter');
            });
            this.classList.add('active-filter');
            currentLocation = this.getAttribute('data-location');
            var searchInputEl = document.getElementById('search-input');
            if (searchInputEl) {
                searchInputEl.value = '';
            }
            // Reset category filter
            var categoryFilterEl = document.getElementById('category-filter');
            if (categoryFilterEl) {
                categoryFilterEl.value = '';
            }
            searchEvents();
            document.getElementById('events-container').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Show/hide back to top button when scrolling
    window.addEventListener('scroll', function() {
        var btn = document.getElementById('back-to-top');
        if (btn) {
            btn.style.display = window.scrollY > 300 ? 'block' : 'none';
        }
    });

});

// Current location filter value
var currentLocation = '';

// Show success message
function showSuccess(message) {
    var success = document.getElementById('success-message');
    var error = document.getElementById('error-message');
    if (success) {
        success.textContent = message;
        success.style.display = 'block';
    }
    if (error) {
        error.style.display = 'none';
    }
}

// Show error message
function showError(message) {
    var error = document.getElementById('error-message');
    var success = document.getElementById('success-message');
    if (error) {
        error.textContent = message;
        error.style.display = 'block';
    }
    if (success) {
        success.style.display = 'none';
    }
}

// Send AJAX request to get filtered events
function searchEvents() {
    var search = document.getElementById('search-input').value;
    var category = document.getElementById('category-filter').value;

    var url = '/php/get_events.php?search=' + encodeURIComponent(search) +
        '&category=' + encodeURIComponent(category) +
        '&location=' + encodeURIComponent(currentLocation);

    fetch(url)
        .then(function(response) {
            return response.json();
        })
        .then(function(events) {
            var container = document.getElementById('events-container');
            container.innerHTML = '';

            if (events.length === 0) {
                container.innerHTML = '<p class="no-results">No events found matching your search.</p>';
                return;
            }

            events.forEach(function(event) {
                var categoryClass = event.category.toLowerCase().replace(/ /g, '-');
                var div = document.createElement('div');
                div.className = 'event';
                div.innerHTML =
                    '<h3>' + event.title + '</h3>' +
                    '<p><strong>Date:</strong> ' + formatDate(event.date) + '</p>' +
                    '<p><strong>Time:</strong> ' + formatTime(event.time) + '</p>' +
                    '<p><strong>Location:</strong> ' + event.location + '</p>' +
                    '<span class="badge badge-' + categoryClass + '">' + event.category + '</span>' +
                    '<p>' + event.description + '</p>';
                container.appendChild(div);
            });
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
}

function formatDate(dateStr) {
    var date = new Date(dateStr);
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-GB', options);
}

// Format time from 09:00:00 to 9:00 AM
function formatTime(timeStr) {
    if (!timeStr) return '';
    var parts = timeStr.split(':');
    var hours = parseInt(parts[0]);
    var minutes = parts[1];
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    return hours + ':' + minutes + ' ' + ampm;
}