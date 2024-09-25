wp.domReady(() => {
    console.log('LOADED MY OWN SCRIPTTTTT');


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





    //   const observer = new MutationObserver(mutations => {
    //     mutations.forEach(mutation => {
    //       if (mutation.type === 'childList') {
    //         mutation.addedNodes.forEach(node => {
    //           if (node.nodeType === Node.ELEMENT_NODE && node.hasAttribute('data-style')) {
    //             const styleElement = node.nextElementSibling;
    //             if (styleElement) {
    //               styleElement.style.cssText = node.getAttribute('data-style');
    //               console.log('changed style');
    //             }
    //           }
    //         });
    //       }
    //     });
    //   });
      
    //   observer.observe(document.body, { childList: true, subtree: true });




// const checkForElement = () => {
//     const elementToWatch = document.querySelector('.nkg-group-hidden'); 

//     if (elementToWatch) {
//         console.log('elementToWatch found:', elementToWatch);
//         const styleElement = elementToWatch.nextElementSibling;
//         if (styleElement) { 

            
//                     styleElement.style.cssText = elementToWatch.getAttribute('data-style');
//                     console.log('changed style');
            
               
            
            
            
//             const observer = new MutationObserver(mutations => {
//               mutations.forEach(mutation => {
//                 if (mutation.type === 'attributes' && mutation.attributeName   
//              === 'data-style') {
//                   styleElement.style.cssText = elementToWatch.getAttribute('data-style');
//                   console.log('changed style');
//                 }
//               });
//             });
            
//             observer.observe(elementToWatch, { attributes: true });
            
            
            
//                     // Remove the event listener to prevent multiple executions
//                     clearInterval(interval);

//         }
//     } else {
//         console.log('elementToWatch not found yet');
//     }
// };

// // Poll for the element every 100 milliseconds
// const interval = setInterval(checkForElement, 100);



// const checkForElement = () => {

//     const elementToWatchList = document.querySelectorAll('.nkg-group-hidden');
// if (elementToWatchList) {
    
//     elementToWatchList.forEach(elementToWatch => {
//         const styleElement = elementToWatch.nextElementSibling;
      
//         if (styleElement) {
//           const observer = new MutationObserver(mutations => {
//             mutations.forEach(mutation => {
//               if (mutation.type === 'attributes' && mutation.attributeName   
//        === 'data-style') {
//                 styleElement.style.cssText = elementToWatch.getAttribute('data-style');
//                 console.log('changed style');
//               }
//             });
//           });
      
//           observer.observe(elementToWatch, { attributes: true });
//         } else {
//           console.log('styleElement not found for:', elementToWatch);
//         }
//       });
// } else {
//     console.log('elementToWatch not found yet');
// }



// }

// const interval = setInterval(checkForElement, 100);


})