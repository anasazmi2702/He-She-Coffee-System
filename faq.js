document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', () => {
        const answer = item.nextElementSibling;
        const toggle = item.querySelector('.faq-toggle');

        if (answer.style.display === 'block') {
            answer.style.display = 'none';
            toggle.textContent = '+';
        } else {
            answer.style.display = 'block';
            toggle.textContent = '-';
        }
    });
});
