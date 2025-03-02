
/**
 * Table Column Resize
 */
class Resize {

	constructor() {

		this.resizeColumn = this.resizeColumn.bind(this);

		// Column that is going to be resized
		this.columnResizing = null;

		// Negative offset calculated by column size
		// minus the total X coordinate of the screen.
		this.columnResizingOffset = 0;

		// Function in charge of adding the resize events
		this.AddResizingEvent();
	}

	//
	AddResizingEvent() {

		document.querySelectorAll('thead th').forEach(th => {

			// 'grip' is the element that will enable the cursor to drag and resize the header
			let grip = document.createElement('div');
			grip.style.height = document.querySelector('table').offsetHeight+'px';
			grip.classList.add('grip');

			th.appendChild(grip);

			grip.addEventListener('mousedown', (e) => {

				this.columnResizing = th;
				this.columnResizingOffset = th.offsetWidth - e.pageX;

				// The added class below will allow to draw a tracking line while resizing
				this.columnResizing.classList.add('resizing');

				// Call the 'resizeColumn' callback function when the mouse is dragging the grip element
				document.addEventListener('mousemove', this.resizeColumn);

				//When the mouse click is released, the targeted header should stop resizing,
				// and remove the tracking line
				document.addEventListener('mouseup', () => {
					document.removeEventListener('mousemove', this.resizeColumn);
					this.columnResizing.classList.remove('resizing');
				});
			});
		});
	}

	// Function responsible for updating the size of the column while the 'grip' element is being dragged
	resizeColumn(e) {
		this.columnResizing.style.minWidth = this.columnResizingOffset + e.pageX + 'px';
	}
}

new Resize();

// --------------------------------------------------------------------------------------------------------------------------------

/**
 * Sorts a table based on its columns
 *
 * @param {HTMLTableElement} table -> table to be sorted
 * @param {number} column -> column index to be sorted
 * @param {boolean} [asc=true] -> determines the direction of the sorting
 */
function sortTableByColumn(table, column, asc = true)
{
    const dirModifier = asc ? 1 : -1;
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.querySelectorAll("tr"));

    // Extract numbering values from the first column
    const numberingValues = rows.map(row => row.cells[0].textContent.trim());

    // Sort each row by comparing the current row and its neighbouring row
    const sortedRows = rows.sort((a, b) => {

        // Column text at table row 'a'
        const aColText = a.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();
        // Column text at table row 'b'
        const bColText = b.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();

        if (aColText?.match(/^[0-9]/g) && bColText?.match(/^[0-9]/g)) { // Sort column for numerical values
            // aColText = parseFloat(aColText);
            // bColText = parseFloat(bColText);

            const aNum = parseInt(aColText);
            const bNum = parseInt(bColText);

            return (aNum - bNum) > 0 ? (1 * dirModifier) : (-1 * dirModifier);
        }

        return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
    });

    // Re-assign numbering values to sorted rows
    sortedRows.forEach((row, index) => {
        row.cells[0].textContent = numberingValues[index];
    });

    // Remove all existing TRs from the table
    /**
     * While there is a single TR in the table, keep looping
     */
    while(tBody.firstChild)
    {
        tBody.removeChild(tBody.firstChild); // Remove that TR
    }

    // Append all (...) the newly sorted rows to the table
    tBody.append(...sortedRows);

    /**
     * Remember sort direction
     */
    // Remove any existing sort direction classes on the headers
    table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    // If the value of asc is true, then add this class below to the specified header
    table.querySelector(`th:nth-child(${ column + 1 })`).classList.toggle("th-sort-asc", asc);
    // Else if the value of asc is false, then add this class below to the specified header
    table.querySelector(`th:nth-child(${ column + 1 })`).classList.toggle("th-sort-desc", !asc);
}

/**
 * Attach the function to the sortable table headers
*/
// Retrieve the table headers with the corresponding class
document.querySelectorAll(".table-sortable th").forEach((headerCell, index) => {

    const sortTrigger = headerCell.querySelector(".sort-trigger");

    sortTrigger.addEventListener("click", () => {

        /**
         * <table> <- to here!
         *      <thead>
         *          <tr>
         *              <th> <- from here
         */
        const tableElement =  headerCell.closest('.table');

        /**
         * headerCell.parentElement.children refers to an array of <th> of a single <tr>
         * The index starts at 0
         */
        const headerIndex = index;

        /**
         * Check whether the clicked header contains an ascending sort class
         */
        const currentIsAscending = headerCell.classList.contains('th-sort-asc');

        /**
         * Call the sort function
         *
         * Note: !currentIsAscending is to switch between ascending and descending
         */
        sortTableByColumn(tableElement, headerIndex, !currentIsAscending);
    });
});

// ---------------

/**
 * Handle show table items per page
 */
document.getElementById('pagination').onchange = function() {

    document.getElementById('itemsPerPage').submit();
};

// ---------------

// ================================ Modal Actions ================================
function insertIdentifier(identifier, type, action)
{
    const currentModalName = action + 'Modal';

    const modal = FlowbiteInstances.getInstance('Modal', currentModalName);

    modal.updateOnShow(() => {

        // --------- Passing the data from the element's attribute doesn't work for some reason
        // Every button clicked for every row will have the slug of the first row of the table
        // const deleteModalBtn = document.getElementById('deleteButton');
        // Extract info from data-bs-* attributes
        // const slug = deleteModalBtn.getAttribute('data-bs-slug');

        if (action == "destroy") {

            // Update the modal's form action
            document.getElementById('deletionModalForm').action = route(type + '.destroy', identifier);

        } else if (action == "restore") {

            // Update the modal's form action
            document.getElementById('restorationModalForm').action = route(type + '.restore', identifier);

        } else if (action == "erase") {

            // Update the modal's form action
            document.getElementById('permaDeletionModalForm').action = route(type + '.erase', identifier);
        }

    });
}

// ---------------

// ================================ Clear Search Input ================================
const input = document.querySelector(".clear-input");
const clearButton = document.querySelector(".clear-input-button");

const handleInputChange = (e) => {
    if (e.target.value && !input.classList.contains("clear-input--touched")) {
        input.classList.add("clear-input--touched");
    } else if (!e.target.value && input.classList.contains("clear-input--touched")) {
        input.classList.remove("clear-input--touched");
    }
}

const handleButtonClick = (e) => {
    input.value = '';
    input.focus();
    input.classList.remove("clear-input--touched");
}

clearButton.addEventListener("click", handleButtonClick);
input.addEventListener("input", handleInputChange);

// ---------------

// ================================ Mobile View Table Row Dropdown ================================
function showDescription(el)
{
    if(el.nextElementSibling.tagName === 'DIV')
    {
        // Get the div element
        let rowHolder = el.nextElementSibling;

        // Show/hide the element
        rowHolder.classList.toggle("hidden");

        // Turn the icon 180 degrees
        el.parentNode.classList.toggle("max-md:[&>td:nth-child(2)]:after:-rotate-180");
    } else
    {
        // create a new div element
        let rowHolder = document.createElement("div");

        // first child of the parent node
        let sibling = el.parentNode.children[2];

        // collecting siblings
        while (sibling)
        {
            // Check that the next sibling is a node element and also not the clicked element
            if (sibling.nodeType === 1 && sibling !== el)
            {
                // Get the first child element within the sibling
                const childElement = sibling.firstElementChild;

                // console.log(childElement);

                // Check to prevent errors and ensure that only elements with children are appended
                if (childElement)
                {
                    // Append sibling to the target div
                    rowHolder.appendChild(childElement.cloneNode(true)); 
                }
            }
            
            sibling = sibling.nextElementSibling;

        }

        rowHolder.classList.add("md:hidden", "w-full", "border-2", "border-primary-600", "rounded-md", "p-4", "mb-3", "flex", "flex-col", "items-center", "space-y-8", "dark:border-primary-300");

        // Add the newly created element after the clicked element 
        el.parentNode.insertBefore(rowHolder, el.parentNode.children[2]);
    }
}