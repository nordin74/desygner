export const setKeyUpListener = (searchImagesInput, thumbnailWrapper, $backendBaseUrl) => {
  searchImagesInput.addEventListener('keyup', async () => {
    if (searchImagesInput.value.length < 3) {
      return;
    }

    const items = await getItemsInfo($backendBaseUrl, searchImagesInput.value);
    thumbnailWrapper.innerHTML = renderItems(items);
  });
}

export const getItemsInfo = async(backendBaseUrl, tag) => {
  const response = await fetch(`${backendBaseUrl}/files?tag=${tag}`);

  return response.json();
};


export const renderItems = (items) => {
  let content = '', left, top = 0, topLock = 0, render;
  for (let i = 0; i < items.length; i++) {
    left = i % 2 !== 0 ? 147 : 0;
    if (topLock > 1) {
      top += 104;
      topLock = 0;
    }
    topLock++
    content += renderTpl(items[i], left, top);
  }

  return content;
}


export const renderTpl = ({ id, url }, left, top) => {
  return (
`<div id="thumb-${id}" class="thumbnail" style="width: 135px; height: 90px; position: absolute; left: ${left}px; top: ${top}px">
  <a class="item" data-popover="tooltip">
    <img style="width: 135px; height: 90px; display: block" src="${url}">
  </a>
  <div data-popover="tooltip" class="overlay image align-bottom"></div>
  <div class="subscription-label" style="background:#6659e3">Free</div>
</div>`
  );
}