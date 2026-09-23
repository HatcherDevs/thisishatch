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

    function initProjectsPage() {
        adjustWidthBasedOnNav();

        window.addEventListener('resize', adjustWidthBasedOnNav);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProjectsPage);
    } else {
        initProjectsPage();
    }
})();