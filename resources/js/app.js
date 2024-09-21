
jQuery(document).ready(function ($) {

    console.log('goooo');

    const acf_parent = document.querySelector('[data-acf-mode="parent"]');
    
    
    // $('[data-acf-mode="parent"]');
    const acf_data = acf_parent.dataset.acf;

    acf_data_json = JSON.parse(acf_data);

    console.log(acf_data_json);
    
   



const acf_children = acf_parent.querySelectorAll('[data-acf-mode="child"]');

const fields = [];

console.log(acf_children);

acf_children.forEach(function(element, index) {
    const data = element.dataset.acf;
    const dataParsed = JSON.parse(data);
  
    console.log('data', dataParsed);
    fields.push(dataParsed);
  });


console.log('fields', fields)
if (acf_data_json) {
    console.log('adding data')
    acf_data_json.fields = fields;
    acf_data_json.test = 'test';
}

console.log(acf_data_json);
})
