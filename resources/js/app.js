
jQuery(document).ready(function ($) {
    console.log('goooo');
    const acf_parent = document.querySelector('[data-acf-mode="parent"]');
    console.log('acf_parent', acf_parent);
    // $('[data-acf-mode="parent"]');

    const acf_data = acf_parent?.dataset?.acf;
    // console.log('acf_data',acf_data);
    acf_data_json = acf_data !== undefined ? JSON.parse(acf_data) : '';
    // console.log('acf_data_json',acf_data_json);
    
const acf_children = acf_parent ?  acf_parent?.nextElementSibling?.querySelectorAll('[data-acf-mode="child"]') : '';

console.log('acf_children', acf_children);

const fields = [];

// console.log(acf_children);

if (acf_children) {
    
    acf_children.forEach(function(element, index) {
        if (element?.dataset?.acf) {
    
            const data = element.dataset.acf;
            const dataParsed = JSON.parse(data);
            
            console.log('data', dataParsed);
            fields.push(dataParsed);
        }
      });
      console.log('fields', fields)
      if (acf_data_json) {
          console.log('adding data')
          acf_data_json.fields = fields;
          acf_data_json.test = 'test';
      }
      
      console.log('ACF DATA:',acf_data_json);
}



// STYLE PREVIEW.. NOT NEEDED FOR FINAL RENDER BECAUSE TAILWIND CLASSES WILL BE USED INSTEAD

$('[data-style]').each(function () {
    // console.log('element', $(this));
    $(this).next().attr('style', $(this).attr('data-style')); }) 
})
