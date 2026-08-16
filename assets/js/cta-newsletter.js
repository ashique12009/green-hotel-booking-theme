document.getElementById('ctaForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const msg  = document.querySelector('.cta-message');
    const btn  = form.querySelector('button[type="submit"]');

    // Please wait state
    msg.textContent = 'Please wait...';
    msg.style.color = '#555';
    btn.disabled = true;
    btn.textContent = 'Please wait...';

    fetch(ghbCta.ajax_url, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        msg.textContent = data.data;
        msg.style.color = data.success ? 'green' : 'red';

        if (data.success) {
            form.reset();
        }
    })
    .catch(() => {
        msg.textContent = 'Something went wrong. Please try again.';
        msg.style.color = 'red';
    })
    .finally(() => {
        // Reset button
        btn.disabled = false;
        btn.textContent = 'Get Started';
    });
});