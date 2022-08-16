document.addEventListener("DOMContentLoaded", () => {
  setKeyUpListener(
    document.getElementById('searchImages'),
    document.getElementById('thumbnail-wrapper'),
    BACKEND_BASE_URL,
  );
});
