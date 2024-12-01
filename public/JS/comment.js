/**
 * Focus on the text area when reply button is clicked
 * 
 * @param {string} commentID 
 */
function onFocus(element)
{
    setTimeout(function() {
        document.getElementById(element).focus();
    }, 50);
}

/**
 * Hide the Flowbite dropdown
 * 
 * @param {string} element 
 */
function hideDropdown(element)
{
    FlowbiteInstances.getInstance('Dropdown', element).hide();
}

document.addEventListener("livewire:navigating", () => {
    // Mutate the HTML before the page is navigated away...
    initFlowbite();
});

document.addEventListener("livewire:navigated", () => {
    // Reinitialize Flowbite components
    initFlowbite();
});