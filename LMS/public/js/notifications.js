// Show loading overlay with smooth animation
function showLoading() {
    const overlay = document.getElementById('loading-overlay');
    const content = document.getElementById('loading-content');
    if (overlay && content) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        setTimeout(() => {
            overlay.style.opacity = '1';
            content.style.transform = 'scale(1)';
            content.style.opacity = '1';
        }, 10);
    }
}

// Hide loading overlay with smooth animation
function hideLoading() {
    const overlay = document.getElementById('loading-overlay');
    const content = document.getElementById('loading-content');
    if (overlay && content) {
        overlay.style.opacity = '0';
        content.style.transform = 'scale(0.95)';
        content.style.opacity = '0';
        setTimeout(() => {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }, 300);
    }
}

// Auto-attach loading to all forms
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Skip if form has data-no-loading attribute
            if (!this.hasAttribute('data-no-loading')) {
                showLoading();
            }
        });
    });
});
