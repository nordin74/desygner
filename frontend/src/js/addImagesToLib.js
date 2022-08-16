document.addEventListener('DOMContentLoaded', () => {
  const thumbnailWrapper = document.getElementById('thumbnail-wrapper');
  thumbnailWrapper.addEventListener('click', e => {
    if (!(e.target && /image|subscription-label/.test(e.target.className))) {
      return;
    }

    if (!confirm('Are you sure you want to add the image to the library?')) {
      return;
    }

    let lib = localStorage.getItem('lib');
    if (lib === null) {
      lib = [];
    } else {
      lib = JSON.parse(lib);
    }

    if (lib.some(el => el.id === e.target.parentNode.id)) {
      return;
    }

    const url = e.target.parentNode.getElementsByTagName('img')[0].src;
    lib.push({ id: e.target.parentNode.id, url: url });
    localStorage.setItem('lib', JSON.stringify(lib));
  });
});
