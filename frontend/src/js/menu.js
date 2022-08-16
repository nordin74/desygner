document.addEventListener('DOMContentLoaded', () => {
  const callToActionBtns = document.querySelector('#tabImages .header-links').children;
  callToActionBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      callToActionBtns.forEach(function(ele) {
        return ele.classList.remove('active');
      });
      let target = e.target;
      if (target.tagName === 'SPAN') {
        target = target.parentElement;
      }
      target.classList.toggle('active');

      if (target.dataset.key === 'library') {
        document.querySelector('.library').style = 'display: block';
        document.querySelector('.search-container').style = 'display: none';
        document.querySelector('.stock').style = 'display: none';
        document.querySelector('.add').style = 'display: none';
      } else if (target.dataset.key === 'stock') {
        document.querySelector('.stock').style = 'display: block';
        document.querySelector('.search-container').style = 'display: grid';
        document.querySelector('.library').style = 'display: none';
        document.querySelector('.add').style = 'display: none';
      }
    });
  });
});