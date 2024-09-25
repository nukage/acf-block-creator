wp.domReady(() => {

    // This script monitors the document for changes to the data-style attribute
    // There is a hidden div that is a sibling of innerblocks and this will
    // transfer the style tag, so although we cannot add style to the innerblocks,
    // via php template, we can do it this weird way. 


    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
          if (mutation.type === 'childList') {
           
            mutation.addedNodes.forEach(node => {
            if (node.nodeType === Node.ELEMENT_NODE && node.hasAttribute('data-style')) {
                const styleElement = node.nextElementSibling;
                if (styleElement) {
                  styleElement.style.cssText = node.getAttribute('data-style');
                  console.log('changed style');
                }
              }
            });


          } else if (mutation.type === 'attributes' && mutation.attributeName === 'data-style') {
            const elementToWatch = mutation.target;
            const styleElement = elementToWatch.nextElementSibling;
            if (styleElement) {
              styleElement.style.cssText = elementToWatch.getAttribute('data-style');
              console.log('changed style');
            }
          }
        });
      });
      
      // Observe for both childList and attribute mutations
      observer.observe(document.body, { childList: true, subtree: true, attributes: true });
})