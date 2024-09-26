jQuery(document).ready(function ($) {
	// STYLE PREVIEW

	$("[data-style]").each(function () {
		$(this).next().attr("style", $(this).attr("data-style"));
	});

	const devMode = document.body.classList.contains("nkg-dev-mode")
		? true
		: false;

    const cssMode =  document.body.classList.contains("nkg-css-mode")
    ? true
    : false;    

        
        const acf_parent = document.querySelector('[data-acf-mode="parent"]');
        const acf_root = acf_parent?.nextElementSibling;
        
        if (!devMode) {
            console.log("Render Mode Enabled");


	// Get ACF JSON and Block.JSON

	function get_block_json() {
		const acf_block = acf_parent?.dataset?.block;
		const acf_block_json = acf_block !== undefined ? JSON.parse(acf_block) : "";

		// console.log(
		// 	`-----> BLOCK.JSON FOR: ${acf_block_json.title}`,
		// 	acf_block_json
		// );
		return acf_block_json;
	}

	get_block_json();

	function get_acf_json() {
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
								acf_clone_children.forEach(function (cloneChildElement, index) {
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
						if (element?.dataset?.acfMode !== "none" && element?.dataset?.acf) {
							fields.push(JSON.parse(element.dataset.acf));
						}
					}
				}
			});

			if (acf_data_json) {
				acf_data_json.fields = fields;
				acf_data_json.test = "test";
			}

			// console.log(`-----> ACF JSON FOR: ${acf_data_json.title}`, acf_data_json);
            return acf_data_json;
		}
	}
	get_acf_json();



        	// CLASS EXTRACTOR
	function classExtractor() {
		
        const whereToPutRules = document.querySelector("pre");

        const classElements = document.querySelectorAll("[data-classes]");



		const classList = {};

		classElements.forEach(function (element, index) {
			const classes = element?.dataset?.classes;
			const name = element?.dataset?.name;
			if (!classes || !name) {
				return;
			}

			classList[name] = classes.split(" ");
		});

		// console.log("classList", classList);

		const container = document.createElement("div");
		container.id = "css-rules-container";
	

        const title = document.createElement("h5");
        title.textContent = "Tailwind CSS";
        whereToPutRules.appendChild(title);

		for (const key in classList) {
			const className = key;
			const rules = classList[key];

			const codeElement = document.createElement("code");
			codeElement.textContent = `.${className} {
            @apply ${rules.join(" ")};
        }\n`;

			container.appendChild(codeElement);
		}

		const hr = document.createElement("hr");
		container.appendChild(hr);



		whereToPutRules.appendChild(container);
	}

    

		function fixSubField() {
			const repeaters = document.querySelectorAll('[data-acf-mode="repeater"]');

			// Change get_field to get_sub_field
			repeaters.forEach(function (repeaterElement) {
				replaceTextInComments(
					repeaterElement.nextElementSibling,
					"get_field",
					"get_sub_field"
				);
			});
		}

		fixSubField();

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

		function removeHidden() {
			const hiddenGroupElements =
				document.querySelectorAll(".nkg-group-hidden");
			const hiddenElements = document.querySelectorAll(
				".nkg-hidden, .nkg-group-hidden"
			);

			hiddenElements.forEach(function (element) {
				element.parentNode.removeChild(element);
			});
		}
	

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

	function printPhpCode() {
		const container = document.createElement("code");
		container.id = "php-container";
		container.textContent = acf_root.outerHTML;
		container.textContent = container.textContent.replaceAll("<php", "<?php");
		container.textContent = container.textContent.replaceAll("<!--", "");
		container.textContent = container.textContent.replaceAll("-->", "");
		container.textContent = container.textContent.replace(/\s{4,}/g, "\n");
		const whereToPutCode = document.querySelector("pre");

        const title = document.createElement("h5");
        title.textContent = "PHP Code";
        whereToPutCode.appendChild(title);

		whereToPutCode.appendChild(container);
		const hr = document.createElement("hr");
		whereToPutCode.appendChild(hr);

	
	}

    function printBlockJson() {
		const container = document.createElement("code");
		container.id = "block-json-container";
		container.textContent = JSON.stringify(get_block_json()), null, 3;
		const whereToPutCode = document.querySelector("pre");
        const title = document.createElement("h5");
        title.textContent = "Block JSON";
        whereToPutCode.appendChild(title);
		whereToPutCode.appendChild(container);
		const hr = document.createElement("hr");
		whereToPutCode.appendChild(hr);
	}
    function printAcfJson() {
		const container = document.createElement("code");
		container.id = "block-json-container";
		container.textContent = JSON.stringify(get_acf_json()), null, 3;
		const whereToPutCode = document.querySelector("pre");
        const title = document.createElement("h5");
        title.textContent = "ACF JSON";
        whereToPutCode.appendChild(title);
		whereToPutCode.appendChild(container);
		const hr = document.createElement("hr");
		whereToPutCode.appendChild(hr);
	}
    if (cssMode) {

        classExtractor();
    }

    printBlockJson();
    printAcfJson();
	removeHidden();
	printPhpCode();
}
});
