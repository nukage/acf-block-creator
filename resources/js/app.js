jQuery(document).ready(function ($) {
 
	// STYLE PREVIEW

	const nkg_groups = document.querySelectorAll(".nkg-group-hidden, .nkg-hidden");
	const nkg_parents = document.querySelectorAll('[data-acf-mode="parent"]');
	// If there's no hidden groups on this page, don't run any code.
	if (!nkg_groups[0]) {
		return;
	}
	$("[data-style]").each(function () {
		$(this).next().attr("style", $(this).attr("data-style"));
	});

	// Check for data-attributes and add them to their sibling element - great for Alpine.js etc
	nkg_groups.forEach((element) => {
		const nextElement = element.nextElementSibling;
		const dataAttributes = element.dataset.attributes
			? JSON.parse(element.dataset.attributes)
			: false;
		if (dataAttributes && nextElement) {
			for (const attribute in dataAttributes) {
				nextElement.setAttribute(attribute, dataAttributes[attribute]);
			}
		}
		replaceATags(element, nextElement);
 

	});



	function replaceATags (acf_parent, acf_root){
		
		if ((acf_parent?.dataset?.element == 'a')) {
			console.log("element.dataset.element", acf_parent.dataset.element);
			const aElement = acf_root.outerHTML.replace(/^<div/, '<a').replace(/<\/div>$/, '</a>');
			acf_root.outerHTML = aElement;
		}

}

 




	const devMode = document.body.classList.contains("nkg-dev-mode")
		? true
		: false;

	const cssMode = document.body.classList.contains("nkg-css-mode")
		? true
		: false;

	const acf_parent = document.querySelector('[data-acf-mode="parent"]');
	const acf_root = acf_parent?.nextElementSibling;

	function removeHidden(acf_parent) {

		const hiddenElements = acf_parent?.nextElementSibling?.querySelectorAll(
			".nkg-hidden, .nkg-group-hidden"
		);

		hiddenElements.forEach(function (element) {
			element.parentNode.removeChild(element);
		});
		acf_parent.parentNode.removeChild(acf_parent);
	}
	///-----------------------RENDER MODE -----------------------------

	if (devMode) {
		// Clean up hidden elements

		nkg_parents.forEach((acf_parent) => {

			removeHidden(acf_parent);
		})
	} else {
		console.log("Render Mode Enabled");

		// Get ACF JSON and Block.JSON

		function get_block_json(acf_parent) {
			const acf_block = acf_parent?.dataset?.block;

			console.log(acf_block);
			const acf_block_json =
				acf_block !== undefined ? JSON.parse(acf_parent.dataset.block) : "";

			// console.log(
			// 	`-----> BLOCK.JSON FOR: ${acf_block_json.title}`,
			// 	acf_block_json
			// );
			return acf_block_json;
		}

		// get_block_json();

		function get_acf_json(acf_parent) {

			const acf_root = acf_parent?.nextElementSibling;
			const acf_data = acf_parent?.dataset?.acf;
			if (!acf_data){
				return;
			}
			console.log('acf_data', acf_data)
			
			const acf_parent_name = acf_parent?.dataset?.name;
	 
			const acf_parent_title = acf_parent?.dataset?.title;
			
			
			
			const acf_data_json = acf_data !== undefined ? JSON.parse(acf_data) : "";
			const acf_parent_key = acf_data_json.key;
			
			const acf_children = acf_root
				? acf_root?.querySelectorAll(
						'[data-acf-mode="child"], [data-acf-mode="repeater"]'
				  )
				: "";

			const fields = acf_data_json?.fields ? acf_data_json.fields : [];

		  

if (acf_children) {
    const labelCount = {}; // Object to keep track of label counts

    // Function to process the child field and update accordingly
    function processChildField(childElement, childField, parentKey, parentLabel, parentName, index, namesep = '-') {
        if (childElement.dataset.acfId == 'inherit') {
            console.log('inherit found');
            childField.key = parentKey + '_' + index;

			if (parentLabel) {
				childField.label = parentLabel + ' ' + childField.label;
			}

			// if (parentName && parentName!== 'false') {
			// 	childField.name = parentName + '-' + childField.name;
			// }

            // Manage the label count for the same label
            if (labelCount[childField.label]) {
                labelCount[childField.label] += 1; // Increment count
				childField.name = childField.name + '-' + labelCount[childField.label]; // Append the count to the name if you want unique CSS classes
                childField.label += ' ' + labelCount[childField.label]; // Append the count to the label
            } else {
                labelCount[childField.label] = 1; // Initialize count
            }

			if (parentName){
				childField.name = parentName + namesep + childField.name;
			}
            
			childElement.dataset.nameOrig = childElement.dataset.name;
			childElement.dataset.name = childField.name;
			if (cssMode){
				// childElement.classList = childField.name;
			}
        }
        return childField;
    }

    acf_children.forEach(function (element, index) {
        if (element?.dataset?.acf) {

            if (element?.dataset?.acfMode === "repeater") {
                const repeaterField = JSON.parse(element.dataset.acf);
                console.log('repeaterField', repeaterField);
                const repeaterKey = repeaterField.key;
                const repeaterSingleTitle = element.dataset.acfSingleTitle;
				const repeaterName = repeaterField.name;

                console.log('repeaterSingleTitle', repeaterSingleTitle);	

                const acf_repeater_children =
                    element?.nextElementSibling?.querySelectorAll(
                        '[data-acf-mode="child"]'
                    );

                const acf_repeater_children_fields = [];
                if (acf_repeater_children) {
                    acf_repeater_children.forEach(function (childElement, index) {
                        if (childElement?.dataset?.acf) {
                            const childField = JSON.parse(childElement.dataset.acf);
                            const processedChildField = processChildField(childElement, childField, repeaterKey, repeaterSingleTitle, repeaterName, index);
                            acf_repeater_children_fields.push(processedChildField);
                            childElement.dataset.acf = ""; // Removing them so they don't get added to the parent
                            childElement.dataset.acfMode = "none";
                        }
                    });
                    repeaterField.sub_fields = acf_repeater_children_fields;
                    fields.push(repeaterField);
                    console.log('repeaterField', repeaterField);
                }
            } else {
                if (
                    element?.dataset?.acfMode !== "none" &&
                    element?.dataset?.acf
                ) {
                    const childField = JSON.parse(element.dataset.acf);
                    const processedChildField = processChildField(element, childField, acf_parent_key, false, acf_parent_name, index, '__');
                    fields.push(processedChildField);
                }
            }
        }
    });

    if (acf_data_json) {
        const utilityClassesObject = fields.splice(fields.findIndex(obj => obj.name === 'utility_classes'), 1)[0];
        fields.push(utilityClassesObject);
        acf_data_json.fields = fields;
    }

    return acf_data_json;
}

		}
		// get_acf_json(); // ONLY RUN ONCE

		// CLASS EXTRACTOR
		function classExtractor(acf_parent) {
			const whereToPutRules = acf_parent.previousElementSibling;

			const sibling = acf_parent.nextElementSibling;

			const name = acf_parent.dataset.name;
		

			 

			const classElements = [acf_parent].concat(...sibling.querySelectorAll("[data-classes]"));


			const classList = {};

			classElements.forEach(function (element, index) {
				const classes = element?.dataset?.classes;
				const name = element?.dataset?.name;
				if (!classes || !name) {
					return;
				}

				classList[name] = classes.split(" ");
			});

			const container = document.createElement("div");
			container.id = "css-rules-container";

			const title = document.createElement("h5");
			title.textContent = "Tailwind CSS";
			whereToPutRules.appendChild(title);

			function removeName(classname) {
				// Remove the parent name from the beginning of the class name
				if (classname.startsWith(name)) {
					const newName =  classname.substring(name.length);
					return newName ? "&" + newName : '';

				}

				return '.' + classname;
			}
			
			const OpeningCodeElement = document.createElement("code");
			OpeningCodeElement.textContent = `.${name} {`
			container.appendChild(OpeningCodeElement)
			for (const key in classList) {
				const className = removeName(key);
				const rules = classList[key];

				const codeElement = document.createElement("code");
				if (!className){
					codeElement.textContent =  `@apply ${rules.join(" ")};`;
				} else {

					codeElement.textContent = `${className} {
				@apply ${rules.join(" ")};
			}\n`;
				}

				container.appendChild(codeElement);
			}

			const closingCodeElement = document.createElement("code");
			closingCodeElement.textContent = `}`
			container.appendChild(closingCodeElement)



			const hr = document.createElement("hr");
			container.appendChild(hr);

			whereToPutRules.appendChild(container);
		}
		function updateInheriterNames(acf_parent) {
			const inheriterElements = acf_parent?.nextElementSibling?.querySelectorAll('[data-acf-id="inherit"]');
			inheriterElements.forEach(function (element) {
				const name = element.dataset.nameOrig ?? '';
				const newName = element.dataset.name ?? '';
				if (name && newName) {
					const nextSibling = element.nextSibling.nextSibling;  
					if (nextSibling && nextSibling.nodeType === 8) {
						console.log('next sibling is a comment node', nextSibling);
						nextSibling.nodeValue = nextSibling.nodeValue.replaceAll(name, newName);
					}
				}
			})
		}
		function fixSubField(acf_parent) {
			const repeaters = acf_parent?.nextElementSibling?.querySelectorAll('[data-acf-mode="repeater"]');
			repeaters.forEach(function (repeaterElement) {
				replaceTextInComments(
					repeaterElement.nextElementSibling,
					"get_field",
					"get_sub_field"
				);
			});
		}

		// Find the hidden elements
		// Replace PHP tags
		// hiddenGroupElements.forEach(function (element) {
		// 	const nextSibling = element?.nextElementSibling;
		// 	if (nextSibling) {
		// 		replaceTextInComments(
		// 			element.nextElementSibling,
		// 			"<php",
		// 			"<?php",
		// 			false
		// 		);
		// 	}
		// });

		function replaceTextInComments(
			element,
			oldText,
			newText,
			commentsToText = false
		) {
			if (!element) return;
			console.log("replaceTextInComments", element, oldText, newText, commentsToText);
			// Get all text nodes within the element and its descendants
			const textNodes = [];
			let elementNodes = element.querySelectorAll(
				":not(script):not(style)"
			);

			elementNodes = elementNodes.forEach((node) => {
				if (node.nodeType === Node.TEXT_NODE) {
					textNodes.push(node);
				} else {
					textNodes.push(...node.childNodes);
				}
			});

			console.log("textNodes", textNodes);

			// Iterate over each text node
			textNodes.forEach((textNode) => {
				// Check if the text node is within a comment
				if (textNode.nodeType === Node.COMMENT_NODE) {
					// Replace the text within the comment

					textNode.nodeValue = textNode.nodeValue.replaceAll(oldText, newText);
					if (commentsToText) {
						const newTextNode = document.createTextNode(textNode.nodeValue);
						textNode.parentNode.replaceChild(newTextNode, textNode);
					}
				} else {
				}
			});
		}


		function printPhpCode(acf_root) {
	 
			const container = document.createElement("code");
			container.id = "php-container";
			container.textContent = acf_root.outerHTML;
			container.textContent = container.textContent.replace(/="php([^"]*)"/g, '="<?php $1 ?>"');
			container.textContent = container.textContent.replaceAll("<php", "<?php");
			container.textContent = container.textContent.replaceAll("<!--", "");
			container.textContent = container.textContent.replaceAll("-->", "");
			container.textContent = container.textContent.replaceAll("&quot;", "\'");
			container.textContent = container.textContent.replaceAll("\\'", "\'");
			container.textContent = container.textContent.replace(/\s{4,}/g, "\n");
			// This was only needed if JSX is true but apparently its true by default now
			// container.textContent = container.textContent.replace(/x-data="\{(.*)\}"/g, '<?= !$is_preview ? \'x-data="{ $1 }"\' : \'\'; ?>'); 
			const whereToPutCode = acf_root.previousElementSibling;

			const title = document.createElement("h5");
			title.textContent = "PHP Code";
			whereToPutCode.appendChild(title);

			whereToPutCode.appendChild(container);
			const hr = document.createElement("hr");
			whereToPutCode.appendChild(hr);
		}

		function printBlockJson(acf_parent) {
			const container = document.createElement("code");
			container.id = "block-json-container";
			(container.textContent = JSON.stringify(get_block_json(acf_parent))), null, 3;
			const whereToPutCode = acf_parent.previousElementSibling;
			const title = document.createElement("h5");
			title.textContent = "Block JSON";
			whereToPutCode.appendChild(title);
			whereToPutCode.appendChild(container);
			const hr = document.createElement("hr");
			whereToPutCode.appendChild(hr);
		}
		function printAcfJson(acf_parent) {
			const container = document.createElement("code");
			container.id = "acf-json-container";
			(container.textContent = JSON.stringify(get_acf_json(acf_parent))), null, 3;
			const whereToPutCode = acf_parent.previousElementSibling;
			const title = document.createElement("h5");
			title.textContent = "ACF JSON";
			whereToPutCode.appendChild(title);
			whereToPutCode.appendChild(container);
			const hr = document.createElement("hr");
			whereToPutCode.appendChild(hr);
		}
		function replaceATags (acf_parent, acf_root){
		
				if ((acf_parent.dataset.element == 'a')) {
					console.log("element.dataset.element", element.dataset.element);
					const aElement = acf_root.outerHTML.replace(/^<div/, '<a').replace(/<\/div>$/, '</a>');
					acf_root.outerHTML = aElement;
				}
		
		}

		function printScript(scriptElement, acf_parent) {
			if (!scriptElement) {
				return;
			}
			console.log(scriptElement);
			const container = document.createElement("code");
			container.id = "script-container";
			container.textContent = scriptElement.innerHTML;
			const whereToPutCode = acf_parent.previousElementSibling;
			const title = document.createElement("h5");
			title.textContent = "Script";
			whereToPutCode.appendChild(title);
			whereToPutCode.appendChild(container);
			const hr = document.createElement("hr");
			whereToPutCode.appendChild(hr);
		}


		nkg_parents.forEach((acf_parent) => {
			const acf_root = acf_parent.nextElementSibling;
			const acf_script = acf_root.nextElementSibling && acf_root.nextElementSibling.tagName.toLowerCase() == 'script' ? acf_root.nextElementSibling : false;
			// console.log("acf_script", acf_root.nextElementSibling.tagName)
	 


			printScript(acf_script, acf_parent)
			printBlockJson(acf_parent);
			printAcfJson(acf_parent);
			// printScript(acf_parent);
			updateInheriterNames(acf_parent);
			fixSubField(acf_parent);
		if (cssMode) {
			classExtractor(acf_parent);
		}
			replaceATags(acf_parent, acf_root);
			removeHidden(acf_parent);
			printPhpCode(acf_root);

 
		 
			$(acf_root).hide();

		});



	}
});
