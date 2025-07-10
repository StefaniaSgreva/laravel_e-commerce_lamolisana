// Loader
export function initLoader() {
    const pageLoader = document.querySelector('.page_loader');

    window.addEventListener('load', () => {
        pageLoader.classList.add('hidden');

        pageLoader.addEventListener('transitionend', () => {
            if (pageLoader.classList.contains('hidden')) {
                pageLoader.style.display = 'none';
            }
        });
    });
}

