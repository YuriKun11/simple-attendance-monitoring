document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-icon-open');
    const closeIcon = document.getElementById('menu-icon-close');
    
    const mainContent = document.querySelector('main'); 
    const header = document.querySelector('header'); 

    const openMenu = () => {
        mobileMenu.classList.remove('transform', '-translate-y-2', 'opacity-0', 'pointer-events-none');
        mobileMenu.classList.add('transform', 'translate-y-0', 'opacity-100');
        openIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    };

    const closeMenu = () => {
        mobileMenu.classList.remove('transform', 'translate-y-0', 'opacity-100');
        mobileMenu.classList.add('transform', '-translate-y-2', 'opacity-0', 'pointer-events-none');
        openIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    };

    toggleButton.addEventListener('click', () => {
        if (mobileMenu.classList.contains('opacity-100')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) { 
            closeMenu();
        }
    });

    document.querySelectorAll('a[href^="#"], .nav-link-home').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            
            if (window.innerWidth < 768 && mobileMenu.classList.contains('opacity-100')) {
                closeMenu();
            }
            
            const targetId = this.getAttribute('href');
            let targetElement = null;

            if (targetId === '#') {
                e.preventDefault();
                window.scrollTo({
                    top: 0, 
                    behavior: 'smooth'
                });
                return; 
            }
            
            targetElement = document.querySelector(targetId);

            if (targetElement) {
                e.preventDefault();

                const headerHeight = header.offsetHeight + 16;
                const offsetTop = targetElement.offsetTop - headerHeight;

                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});