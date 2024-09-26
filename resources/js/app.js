
jQuery(document).ready(function ($) {
    console.log('goooo');
    const acf_parent = document.querySelector('[data-acf-mode="parent"]');
    console.log('acf_parent', acf_parent);
    // $('[data-acf-mode="parent"]');

    const acf_data = acf_parent?.dataset?.acf;
    const acf_block = acf_parent?.dataset?.block;
    const acf_block_json = acf_block !== undefined ? JSON.parse(acf_block) : '';

    
    
    // console.log('acf_data',acf_data);
    const acf_data_json = acf_data !== undefined ? JSON.parse(acf_data) : '';
    // console.log('acf_data_json',acf_data_json);
    
    const acf_children = acf_parent ?  acf_parent?.nextElementSibling?.querySelectorAll('[data-acf-mode="child"]') : '';
    
    console.log('acf_children', acf_children);
    
    const fields = acf_data_json?.fields ? acf_data_json.fields : [];
    
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
        
        console.log(`-----> ACF JSON FOR: ${acf_data_json.title}`,acf_data_json);
        console.log(`-----> ACF BLOCK.JSON FOR: ${acf_block_json.title}`,acf_block_json);
}



// STYLE PREVIEW.. NOT NEEDED FOR FINAL RENDER BECAUSE TAILWIND CLASSES WILL BE USED INSTEAD

$('[data-style]').each(function () {
    // console.log('element', $(this));
    $(this).next().attr('style', $(this).attr('data-style')); }) 
})
