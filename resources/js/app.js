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
			const acf_block_json =
				acf_block !== undefined ? JSON.parse(acf_block) : "";

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

			const acf_data_json = acf_data !== undefined ? JSON.parse(acf_data) : "";

			const acf_children = acf_root
				? acf_root?.querySelectorAll(
						'[data-acf-mode="child"], [data-acf-mode="repeater"]'
				  )
				: "";

			const fields = acf_data_json?.fields ? acf_data_json.fields : [];

			if (acf_children) {
				acf_children.forEach(function (element, index) {
					if (element?.dataset?.acf) {
						if (element?.dataset?.acfMode === "repeater") {
							const repeaterField = JSON.parse(element.dataset.acf);
							const nextSibling = element.nextElementSibling;
							const siblings = element.parentNode.children;
							for (let i = 0; i < siblings.length; i++) {
								const sibling = siblings[i];
								if (sibling !== nextSibling) {
									// Turn off ACF mode on clone children
									const acf_clone_children = sibling.querySelectorAll(
										'[data-acf-mode="child"]'
									);
									acf_clone_children.forEach(function (
										cloneChildElement,
										index
									) {
										cloneChildElement.dataset.acfMode = "none";
									});
								}
							}

							const acf_repeater_children =
								element?.nextElementSibling?.querySelectorAll(
									'[data-acf-mode="child"]'
								);

							const acf_repeater_children_fields = [];
							if (acf_repeater_children) {
								acf_repeater_children.forEach(function (childElement, index) {
									if (childElement?.dataset?.acf) {
										acf_repeater_children_fields.push(
											JSON.parse(childElement.dataset.acf)
										);
										childElement.dataset.acf = ""; // Removing them so they don't get added to the parent
										childElement.dataset.acfMode = "none";
									}
								});
								repeaterField.sub_fields = acf_repeater_children_fields;
								fields.push(repeaterField);
							}
						} else {
							if (
								element?.dataset?.acfMode !== "none" &&
								element?.dataset?.acf
							) {
								
								fields.push(JSON.parse(element.dataset.acf));
							}
						}
					}
				});

				if (acf_data_json) {
					const utilityClassesObject = fields.splice(fields.findIndex(obj => obj.name === 'utility_classes'), 1)[0];
					fields.push(utilityClassesObject);


					acf_data_json.fields = fields;
			
				}

				// console.log(
				// 	`-----> ACF JSON FOR: ${acf_data_json.title}`,
				// 	acf_data_json
				// );
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

		function fixSubField(acf_parent) {
			const repeaters = acf_parent?.nextElementSibling?.querySelectorAll('[data-acf-mode="repeater"]');

			// Change get_field to get_sub_field
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
			// Get all text nodes within the element and its descendants
			const textNodes = [];
			let elementNodes = element.parentNode.querySelectorAll(
				":not(script):not(style)"
			);

			elementNodes = elementNodes.forEach((node) => {
				if (node.nodeType === Node.TEXT_NODE) {
					textNodes.push(node);
				} else {
					textNodes.push(...node.childNodes);
				}
			});

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
			console.log("acf_script", acf_root.nextElementSibling.tagName)
	 


			printScript(acf_script, acf_parent)
			printBlockJson(acf_parent);
			printAcfJson(acf_parent);
			// printScript(acf_parent);
			fixSubField(acf_parent);
		if (cssMode) {
			classExtractor(acf_parent);
		}
			replaceATags(acf_parent, acf_root);
			removeHidden(acf_parent);
			printPhpCode(acf_root);
		});


	}
});
