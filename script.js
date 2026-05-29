document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.contact-btn');
    const blocks = document.querySelectorAll('.contact-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {

            const country = btn.dataset.country;

            buttons.forEach(b => b.classList.remove('active'));
            blocks.forEach(block => block.classList.remove('active'));

            btn.classList.add('active');

            const target = document.getElementById(country);
            if (target) target.classList.add('active');
        });
    });


    const dropdown = document.querySelector('.dropdown');
    const selected = document.querySelector('.dropdown-selected');
    const items = document.querySelectorAll('.dropdown-item');
    const input = document.querySelector('.dropdown input');

    if (dropdown && selected) {
        selected.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });
    }

    if (items.length && selected) {
        items.forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();

                selected.textContent = item.textContent;

                if (input) {
                    input.value = item.textContent;
                }

                dropdown.classList.remove('open');
            });
        });
    }

    document.addEventListener('click', () => {
        if (dropdown) dropdown.classList.remove('open');
    });

});

document.addEventListener('DOMContentLoaded', () => {

    const reveals = document.querySelectorAll('.reveal');

    function revealOnScroll() {
        const windowHeight = window.innerHeight;

        reveals.forEach(el => {
            const elementTop = el.getBoundingClientRect().top;

            if (elementTop < windowHeight - 100) {
                el.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();


});

document.addEventListener('DOMContentLoaded', () => {

    const params = new URLSearchParams(window.location.search);
    const city = params.get('city');

    const buttons = document.querySelectorAll('.contact-btn');
    const blocks = document.querySelectorAll('.contact-item');

    function showCity(cityName) {

        buttons.forEach(b => b.classList.remove('active'));
        blocks.forEach(block => block.classList.remove('active'));

        const btn = document.querySelector(`[data-country="${cityName}"]`);
        const target = document.getElementById(cityName);

        if (btn) btn.classList.add('active');
        if (target) target.classList.add('active');
    }

    if (city) {
        showCity(city);
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            showCity(btn.dataset.country);
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {

    const hash = window.location.hash.replace('#', '');

    const buttons = document.querySelectorAll('.contact-btn');
    const blocks = document.querySelectorAll('.contact-item');

    function showCity(cityName) {

        buttons.forEach(b => b.classList.remove('active'));
        blocks.forEach(block => block.classList.remove('active'));

        const btn = document.querySelector(`[data-country="${cityName}"]`);
        const target = document.getElementById(cityName);

        if (btn) btn.classList.add('active');
        if (target) {
            target.classList.add('active');

            setTimeout(() => {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        }
    }

    if (hash) {
        showCity(hash);
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const city = btn.dataset.country;
            showCity(city);

            history.replaceState(null, null, `#${city}`);
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    const galleries = document.querySelectorAll('.house-image');

    galleries.forEach(gallery => {
        const mainImage = gallery.querySelector('img[id^="mainImage"]');
        const thumbs = gallery.querySelectorAll('.thumb');

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                mainImage.src = thumb.src;

                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
            });
        });
    });
});
