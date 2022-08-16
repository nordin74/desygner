document.addEventListener('DOMContentLoaded', () => {
  const lib = document.querySelector('[data-key="library"]');
  lib.addEventListener('click', e => {
    let lib = localStorage.getItem('lib');
    if (lib === null) {
      lib = [];
    } else {
      lib = JSON.parse(lib);
    }

    const ul = document.querySelector('.library .thumbnail-wrapper');
    ul.innerHTML = RenderItems.render(lib);
  });
});
