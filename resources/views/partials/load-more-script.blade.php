const btn = document.getElementById('load-more-btn');
const spinner = document.getElementById('load-more-spinner');
const container = document.getElementById('items-container');

if (btn) {
    btn.addEventListener('click', loadMore);

    // Auto-load on scroll to sentinel
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) loadMore();
    }, { rootMargin: '200px' });
    observer.observe(btn);
}

async function loadMore() {
    if (!btn) return;
    const page = parseInt(btn.dataset.page);
    const url  = btn.dataset.url;

    btn.disabled = true;
    btn.style.opacity = '0.5';
    if (spinner) { spinner.style.display = 'block'; }

    try {
        const res = await fetch(`${url}?page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();

        if (data.html) {
            const div = document.createElement('div');
            div.innerHTML = data.html;
            container.appendChild(div);
        }

        if (data.has_more) {
            btn.dataset.page = data.next_page;
            btn.disabled = false;
            btn.style.opacity = '1';
        } else {
            btn.closest('div').innerHTML = '<p class="text-gray-400 text-sm">All items loaded.</p>';
        }
    } catch (e) {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
    if (spinner) { spinner.style.display = 'none'; }
}
