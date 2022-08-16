!function(e){var t,n;!function(e){e.list=function(){var e=[];function t(t,n){t||e.push(n)}function n(e,n){try{t(e(),n)}catch(e){t(!1,n)}}return n((function(){var e=document.createElement("canvas");return!(!e.getContext||!e.getContext("2d"))}),"HTML5 Canvas"),t("undefined"!=typeof WebSocket,"WebSockets"),n((function(){var e=document.createElement("div");return"draggable"in e||"ondragstart"in e&&"ondrop"in e}),"HTML5 Drag-and-Drop"),t("undefined"!=typeof URL,"window.URL Support"),t("undefined"!=typeof XMLHttpRequest,"XML Http Requests"),n((function(){return"undefined"!=typeof Uint32Array&&"undefined"!=typeof Uint8Array&&void 0!==new Uint8Array(2).set}),"Native Type Arrays"),n((function(){var e=document.createElement("canvas");e.width=1,e.height=1;var t=e.getContext("2d").getImageData(0,0,1,1).data;return new Int32Array(t.buffer).length>0}),"ImageData.data is not a Uint8ClampedArray"),t(!(!window.history||!window.history.pushState),"HTML5 History"),t("undefined"!=typeof Worker,"Web Workers"),t(!!Date.now,"Date.now()"),n((function(){return!!new Blob}),"Blob and/or Blob Constructor"),t(navigator.userAgent.indexOf("Trident/7.0;")<0&&navigator.userAgent.indexOf("rv:11.0")<0,"IE 11 not supported due to browser bugs"),e.sort(),e}}(t||(t={})),function(e){let n=!1,i=!1,o=null,r=!0,a=null,d=null,l=null,u=null,c="",s=navigator.userAgent.indexOf("Trident")>=0?"about:blank":"data:,Loading...",p=null;function f(){d.contentWindow.location.replace(s)}function m(){d&&(document.body.style.overflow=c,a.style.display="none",f(),a.removeChild(d),d=null)}function g(e){try{p(e)}catch(e){}}function y(e){if(d&&e.source==d.contentWindow){let t=JSON.parse(e.data);if(t.error)m(),g({event:"error",error:t.error});else switch(t.command){case"SavedAndResultReady":t.success&&(r&&m(),g({event:"result-generated",image:t.image}));break;case"Exit":m(),g({event:"editor-exit"})}}}e.initialize=function(e){if("number"!=typeof e.apiId)throw"Must include apiId in opts";if(void 0!==e.apiKey)throw"Must NOT include apiKey in opts - it is private!";o=e,n||window.addEventListener("message",y),n=!0;let r=t.list();return i=0==r.length,r},e.edit=function(e,t){if(!n)throw"Please call ClippingMagic.initialize() first";if(!i)throw"Sorry, can't run in this browser";if(d)throw"Sorry, can only have one editor open at a time";r=!e.images,p=t,function(e){let t;null==a&&(a=document.createElement("div"),a.id="clipping-magic-container",document.body.appendChild(a),t=a.style,t.position="fixed",t.top="0",t.left="0",t.width="100%",t.height="100%",t.zIndex="2147483647",t.background="rgba(0, 0, 0, 0.5)",window.screen.width>768&&(t.padding="10px"),t.boxSizing="border-box"),null==d&&(d=document.createElement("iframe"),d.name="clipping-magic-iframe",d.id=d.name,a.appendChild(d),t=d.style,t.background="#FFFFFF",t.width="100%",t.height="100%",d.setAttribute("seamless","seamless"),d.setAttribute("frameborder","0")),null==l&&(l=document.createElement("form"),l.id="clipping-magic-form",l.style.display="none",document.body.appendChild(l),l.method="POST",l.target=d.name,l.setAttribute("autocomplete","off")),null==u&&(u=document.createElement("input"),u.setAttribute("type","hidden"),u.setAttribute("name","json"),l.appendChild(u)),f();let n="https://clippingmagic.com/api/v1/edit/"+encodeURIComponent(o.apiId)+"?useStickySettings="+!!e.useStickySettings+"&hideBottomToolbar="+!!e.hideBottomToolbar;e.locale&&(n+="&lc="+encodeURIComponent(e.locale)),l.action=n,u.setAttribute("value",JSON.stringify(e)),HTMLFormElement.prototype.submit.call(l),a.style.display="block",c=document.body.style.overflow,document.body.style.overflow="hidden"}(e)},e.close=function(){m()}}(n||(n={})),window.ClippingMagic=n}("undefined"==typeof ClippingMagicExport?ClippingMagicExport={}:ClippingMagicExport);