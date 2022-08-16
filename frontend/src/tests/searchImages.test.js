/**
 * @jest-environment jsdom
 */

import { setKeyUpListener } from '../js/searchImagesFx';
import { BACKEND_BASE_URL } from '../js/constants';

global.fetch = jest.fn(() =>
  Promise.resolve({
    json: () => Promise.resolve([{ id: 1, url: "https://jmsliu.com/wp-content/uploads/2015/01/php.jpg" }])
  })
);

test('Render items', async () => {
  document.body.innerHTML =
`<input type="text" id="searchImages" name="search" placeholder="Search Image from stock assets" autocomplete="off">
<div class="thumbnail-wrapper" id ="thumbnail-wrapper" style="position: relative; height: 2276px;"/>`;

  setKeyUpListener(
    document.getElementById('searchImages'),
    document.getElementById('thumbnail-wrapper'),
    BACKEND_BASE_URL,
  );

  document.getElementById('searchImages').value = 'crane';
  const event = new KeyboardEvent('keyup', { keyCode: 69 /* letter e */, bubbles: true});
  document.getElementById('searchImages').dispatchEvent(event);
  await new Promise(process.nextTick);

  expect(document.getElementById('thumbnail-wrapper').innerHTML).toEqual(
`<div id="thumb-1" class="thumbnail" style="width: 135px; height: 90px; position: absolute; left: 0px; top: 0px">
  <a class="item" data-popover="tooltip">
    <img style="width: 135px; height: 90px; display: block" src="https://jmsliu.com/wp-content/uploads/2015/01/php.jpg">
  </a>
  <div data-popover="tooltip" class="overlay image align-bottom"></div>
  <div class="subscription-label" style="background:#6659e3">Free</div>
</div>`
  )
});