 // Mobile menu submenu toggle with arrow rotation and accordion behavior (new structure)
 document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.navbar-mobile-link.has-submenu').forEach(function (link) {
        var arrow = link.querySelector('.mobile-arrow i');
        var submenu = link.nextElementSibling;
        link.addEventListener('click', function (e) {
            e.preventDefault();
            // أغلق كل القوائم الأخرى
            document.querySelectorAll('.mobile-submenu').forEach(function (other) {
                if (other !== submenu) {
                    other.style.display = 'none';
                    var otherArrow = other.previousElementSibling.querySelector('.mobile-arrow i');
                    if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
                }
            });
            // افتح/اغلق القائمة الحالية
            var isOpen = submenu.style.display === 'block';
            submenu.style.display = isOpen ? 'none' : 'block';
            if (arrow) arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
        });
    });
});

       // Desktop search toggle logic
    document.addEventListener('DOMContentLoaded', function () {
        var searchIcon = document.getElementById('desktop-search-icon');
        var searchForm = document.getElementById('desktop-search-form');
        var closeBtn = document.getElementById('desktop-search-close');
        var navbarCenter = document.querySelector('.navbar-center');
        
        if (searchIcon && searchForm && closeBtn && navbarCenter) {
            searchIcon.addEventListener('click', function (e) {
                e.preventDefault();
                searchIcon.style.display = 'none';
                searchForm.style.display = 'flex';
                navbarCenter.classList.add('search-active');
                searchForm.querySelector('input').focus();
            });
            closeBtn.addEventListener('click', function () {
                searchForm.style.display = 'none';
                searchIcon.style.display = '';
                navbarCenter.classList.remove('search-active');
            });
            document.addEventListener('keydown', function (e) {
                if (searchForm.style.display === 'flex' && (e.key === 'Escape' || e.key === 'Esc')) {
                    searchForm.style.display = 'none';
                    searchIcon.style.display = '';
                    navbarCenter.classList.remove('search-active');
                }
            });
        }
    });



    



// ========================================================= this is shuld be last secript 

// Loading screen
window.addEventListener('load', function () {
    const loading = document.getElementById('loading');
    setTimeout(() => {
        loading.classList.add('hidden');
        setTimeout(() => {
            loading.style.display = 'none';
        }, 500);
    }, 1000);
});

// Mobile navigation
function openMobileNav() {
    const overlay = document.getElementById('navbarMobileOverlay');
    const button = document.querySelector('.navbar-mobile-toggle');
    overlay.classList.add('active');
    button.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
}

function closeMobileNav() {
    const overlay = document.getElementById('navbarMobileOverlay');
    const button = document.querySelector('.navbar-mobile-toggle');
    overlay.classList.remove('active');
    button.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
}

// Navbar scroll effect
window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar-custom');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Scroll to top functionality
const scrollToTopBtn = document.getElementById('scrollToTop');

window.addEventListener('scroll', function () {
    if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add('visible');
    } else {
        scrollToTopBtn.classList.remove('visible');
    }
});

scrollToTopBtn.addEventListener('click', function () {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Search functionality
function handleSearch(event) {
    event.preventDefault();
    const searchInput = event.target.querySelector('input');
    const searchTerm = searchInput.value.trim();

    if (searchTerm) {
        // Implement search functionality here
        console.log('Searching for:', searchTerm);
        alert(`Searching for: ${searchTerm}`);
    }
}

// Keyboard navigation for mobile menu
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeMobileNav();
    }
});

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe elements for animation
document.addEventListener('DOMContentLoaded', function () {
    const animatedElements = document.querySelectorAll('.event-block, .programme-block');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});

// Language switcher functionality
document.querySelectorAll('[role="button"]').forEach(button => {
    button.addEventListener('click', function () {
        const lang = this.textContent.trim();
        console.log('Switching to language:', lang);
        // Implement language switching here
    });
});

// Performance optimization: Lazy loading for images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}








