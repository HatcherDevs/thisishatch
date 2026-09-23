(function () {
    function adjustWidthBasedOnNav() {
        const navLink = document.querySelector('#nav_about a');
        const projectsTab = document.querySelector('#projects-tab');

        if (!navLink || !projectsTab) {
            return;
        }

        if (window.matchMedia('(max-width: 767px)').matches) {
            const imgWidth = navLink.offsetWidth;

            let remainingWidth =
                100 - (imgWidth / window.innerWidth * 100);

            remainingWidth += 10.64;

            projectsTab.style.width = `${remainingWidth}%`;
        } else {
            projectsTab.style.width = '';
        }
    }

    function initProjectFilter() {
        const filterButtons = document.querySelectorAll(
            '#projects-tab [data-category]'
        );

        const projectCards = document.querySelectorAll(
            '#projects-grid .project-card'
        );

        if (!filterButtons.length || !projectCards.length) {
            return;
        }

        filterButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const selectedCategory = button.dataset.category;

                filterButtons.forEach(function (item) {
                    item.classList.remove('active');
                });

                button.classList.add('active');

                projectCards.forEach(function (card) {
                    const cardCategory = card.dataset.category;

                    const shouldShow =
                        selectedCategory === 'all' ||
                        cardCategory === selectedCategory;

                    card.style.display = shouldShow ? '' : 'none';
                });
            });
        });
    }

    function initProjectsPage() {
        adjustWidthBasedOnNav();
        initProjectFilter();

        window.addEventListener('resize', adjustWidthBasedOnNav);
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initProjectsPage
        );
    } else {
        initProjectsPage();
    }
})();