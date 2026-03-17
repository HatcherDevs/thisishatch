// Navbar functionality
document.addEventListener('DOMContentLoaded', function () {
    // Desktop Search Toggle
    const searchIcon = document.getElementById('desktop-search-icon');
    const searchForm = document.getElementById('desktop-search-form');
    const searchClose = document.getElementById('desktop-search-close');

    if (searchIcon && searchForm) {
        searchIcon.addEventListener('click', function (e) {
            e.preventDefault();
            searchForm.classList.add('active');
            searchForm.style.display = 'flex';
            searchForm.querySelector('input').focus();
        });
    }

    if (searchClose) {
        searchClose.addEventListener('click', function () {
            searchForm.classList.remove('active');
            searchForm.style.display = 'none';
        });
    }

    // Mobile Menu Toggle
    window.openMobileNav = function () {
        const overlay = document.getElementById('navbarMobileOverlay');
        if (overlay) {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeMobileNav = function () {
        const overlay = document.getElementById('navbarMobileOverlay');
        if (overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // Mobile Submenu Toggle
    const mobileMenuLinks = document.querySelectorAll('.navbar-mobile-menu > li > a');
    mobileMenuLinks.forEach(link => {
        const parentLi = link.parentElement;
        const submenu = parentLi.querySelector('ul');

        if (submenu) {
            // Add arrow indicator
            const arrow = document.createElement('span');
            arrow.innerHTML = ' <i class="fas fa-chevron-down"></i>';
            arrow.style.cssText = 'float: right; transition: transform 0.3s ease;';
            link.appendChild(arrow);

            link.addEventListener('click', function (e) {
                e.preventDefault();
                const isOpen = submenu.style.display === 'block';
                submenu.style.display = isOpen ? 'none' : 'block';
                arrow.querySelector('i').style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        }
    });
});
