// ========================================================
// Main Client-Side JavaScript
// Handles responsive sidebar toggle and bookmark interactions
// ========================================================

document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Mobile Sidebar Toggle
    // Opens and closes the navigation sidebar on mobile viewports
    const sidebarToggle = document.getElementById('sidebarToggle');
    const appSidebar = document.querySelector('.app-sidebar');

    if (sidebarToggle && appSidebar) {
        sidebarToggle.addEventListener('click', function () {
            appSidebar.classList.toggle('active');
        });
    }

    // 2. Interactive SVG Bookmark Toggle
    // Toggles bookmark state between saved (filled) and unsaved (outline)
    const bookmarkButtons = document.querySelectorAll('.btn-bookmark-action');

    bookmarkButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const svgIcon = this.querySelector('svg');
            
            // Check if current icon is filled with black
            const isFilled = svgIcon.getAttribute('fill') === '#000000';

            if (isFilled) {
                // Change to transparent outline (Unbookmarked)
                svgIcon.setAttribute('fill', 'none');
                svgIcon.setAttribute('stroke', 'currentColor');
            } else {
                // Fill with solid black (Bookmarked)
                svgIcon.setAttribute('fill', '#000000');
                svgIcon.setAttribute('stroke', '#000000');
            }
        });
    });

});
