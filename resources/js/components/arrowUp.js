// Arrow Up
export function initArrowUp() {
    const arrowUp = document.querySelector('.arrow_up');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            arrowUp.classList.add('visible');
        } else {
            arrowUp.classList.remove('visible');
        }
    });

    arrowUp.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}
