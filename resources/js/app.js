import './bootstrap';

// NOTIFICATION
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.textContent = message;

    notification.classList.remove('hidden');
    notification.classList.remove('bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

    if (type === 'success') {
        notification.classList.add('bg-green-100', 'text-green-700', 'border', 'border-green-300');
    } else {
        notification.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-300');
    }

    // Auto-hide after 5 seconds
    setTimeout(() => {
        notification.classList.add('hidden');
        notification.textContent = '';
    }, 5000);
}

window.showNotification = showNotification;