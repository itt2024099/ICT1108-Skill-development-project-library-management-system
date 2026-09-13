// main script for buttons and search

document.addEventListener('DOMContentLoaded', function () {

  // bookmark button toggle
  document.querySelectorAll('.btn-bookmark').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      this.classList.toggle('bookmarked');
      const isBookmarked = this.classList.contains('bookmarked');
      const svg = this.querySelector('svg');
      if (svg) {
        svg.setAttribute('fill', isBookmarked ? '#000000' : 'none');
      }
      showToast(isBookmarked ? 'Book added to your Bookmarks!' : 'Book removed from Bookmarks.', isBookmarked ? 'info' : 'default');
    });
  });

  // waitlist join button
  document.querySelectorAll('.btn-waitlist').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      if (!this.classList.contains('joined')) {
        this.classList.add('joined');
        this.textContent = 'Joined Waitlist (Queue #1)';
        this.style.backgroundColor = '#16a34a';
        this.style.borderColor = '#16a34a';
        this.style.color = '#ffffff';
        showToast('Successfully reserved! You will be notified when this book is returned.', 'success');
      } else {
        this.classList.remove('joined');
        this.textContent = 'Join Waitlist';
        this.style.backgroundColor = '';
        this.style.borderColor = '';
        this.style.color = '';
        showToast('You left the reservation waitlist.', 'default');
      }
    });
  });

  // table search filter
  const searchTableInput = document.getElementById('tableSearchInput');
  if (searchTableInput) {
    searchTableInput.addEventListener('keyup', function () {
      const query = this.value.toLowerCase().trim();
      const rows = document.querySelectorAll('.wireframe-table tbody tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    });
  }

  // catalog search filter
  const catalogSearchInput = document.getElementById('catalogSearchInput');
  if (catalogSearchInput) {
    catalogSearchInput.addEventListener('keyup', function () {
      const query = this.value.toLowerCase().trim();
      const cards = document.querySelectorAll('.book-card');
      cards.forEach(card => {
        const title = card.querySelector('.book-title')?.textContent.toLowerCase() || '';
        const author = card.querySelector('.book-author')?.textContent.toLowerCase() || '';
        card.style.display = (title.includes(query) || author.includes(query)) ? '' : 'none';
      });
    });
  }

  // toast message popup
  window.showToast = function (message, type = 'default') {
    let container = document.querySelector('.lms-toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'lms-toast-container';
      container.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
      document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    let bgColor = '#111827';
    if (type === 'success') bgColor = '#15803d';
    if (type === 'info') bgColor = '#0369a1';
    if (type === 'alert') bgColor = '#b91c1c';

    toast.style.cssText = `background:${bgColor};color:#ffffff;padding:12px 20px;border-radius:8px;font-size:14px;font-weight:600;box-shadow:0 10px 15px -3px rgba(0,0,0,0.3);opacity:0;transform:translateY(10px);transition:all 0.3s ease;`;
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateY(0)';
    }, 10);

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(10px)';
      setTimeout(() => toast.remove(), 300);
    }, 3200);
  };

});

// System integration and link validation completed

