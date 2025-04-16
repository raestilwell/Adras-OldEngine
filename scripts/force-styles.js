// Save this as force-styles.js
(function() {
	// Function to force styles on all elements
	function forceStyles() {
		// Get colors from data attributes we'll set on the body
		const bgcolor = document.body.getAttribute('data-bgcolor') || '#000000';
		const tcolor = document.body.getAttribute('data-tcolor') || '#FFFFFF';
		
		console.log('Forcing styles - BG:', bgcolor, 'Text:', tcolor);
		
		// Apply to ALL elements on the page
		const allElements = document.querySelectorAll('*');
		
		allElements.forEach(function(element) {
			// Skip script and style tags
			if (element.tagName === 'SCRIPT' || element.tagName === 'STYLE') {
				return;
			}
			
			// Force background color with inline style (highest priority)
			element.style.setProperty('background-color', bgcolor, 'important');
			element.style.setProperty('color', tcolor, 'important');
			
			// Remove any background classes from Bootstrap
			if (element.classList.contains('bg-light') || 
				element.classList.contains('bg-white') || 
				element.classList.contains('bg-dark')) {
				element.classList.remove('bg-light', 'bg-white', 'bg-dark');
			}
			
			// For special elements with their own backgrounds
			if (element.classList.contains('window-alert')) {
				element.style.setProperty('background-color', bgcolor, 'important');
			}
		});
		
		// Force body styles specifically
		document.body.style.setProperty('background-color', bgcolor, 'important');
		document.body.style.setProperty('color', tcolor, 'important');
		
		// Force html styles
		document.documentElement.style.setProperty('background-color', bgcolor, 'important');
		document.documentElement.style.setProperty('color', tcolor, 'important');
		
		// Handle any iframes
		const iframes = document.querySelectorAll('iframe');
		iframes.forEach(function(iframe) {
			try {
				const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
				iframeDoc.body.style.setProperty('background-color', bgcolor, 'important');
				iframeDoc.body.style.setProperty('color', tcolor, 'important');
				
				const iframeElements = iframeDoc.querySelectorAll('*');
				iframeElements.forEach(function(el) {
					if (el.tagName !== 'SCRIPT' && el.tagName !== 'STYLE') {
						el.style.setProperty('background-color', bgcolor, 'important');
						el.style.setProperty('color', tcolor, 'important');
					}
				});
			} catch(e) {
				console.log('Could not access iframe:', e);
			}
		});
	}
	
	// Run on page load
	window.addEventListener('DOMContentLoaded', forceStyles);
	
	// Also run after a delay to catch any late-loading content
	setTimeout(forceStyles, 500);
	setTimeout(forceStyles, 1000);
	setTimeout(forceStyles, 2000);
	
	// Set up a mutation observer to catch any new elements
	const observer = new MutationObserver(forceStyles);
	observer.observe(document.body, { 
		childList: true, 
		subtree: true,
		attributes: true,
		attributeFilter: ['style', 'class']
	});
})();