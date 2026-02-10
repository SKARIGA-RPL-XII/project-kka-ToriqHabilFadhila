// Check if browser supports notifications
if ('Notification' in window) {
    // Request permission on first visit
    if (Notification.permission === 'default') {
        Notification.requestPermission();
    }
}

// Function to show notification (called from backend)
function showNotification(title, message) {
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification(title, {
            body: message,
            icon: '/images/LMS.png',
            badge: '/images/LMS.png',
            requireInteraction: false
        });
    }
}
