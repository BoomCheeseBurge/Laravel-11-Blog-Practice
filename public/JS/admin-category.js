// ================================ Create Modal Button ================================
function createCat()
{
    let selColor = "";
    let colorChange = "";

    const currentModalName = "createModal";
    const catColor = document.getElementById('color');

    const colorDisplay2 = document.getElementById('colorDisplay2');

    const modal = FlowbiteInstances.getInstance('Modal', currentModalName);

    // ================================ Color Display ================================
    // Change the color display depending on the selected color from the dropdown list
    catColor.addEventListener('change', function() {
        if (modal.isVisible()) {
            // console.log('Color change: ', colorChange);
            if (colorChange) {
                colorDisplay2.classList.remove(colorChange);
            }
            selColor = "bg-"+this.value+"-400";
            colorDisplay2.classList.add(selColor);
            colorChange = selColor;
            // console.log('Color change: ', selColor);
        }
    });

    modal.updateOnHide(() => {

        selColor = "bg-"+catColor.value+"-400";
        colorDisplay2.classList.remove(selColor);
        // Set the first option to be selected first upon opening the modal again
        document.getElementsByName('color')[0].value = 'default';

    });
}

// ================================ Edit Modal Button ================================
function insertEdit(slug, name, color)
{
    let selColor = "bg-"+color+"-400";
    const currentModalName = "editModal";

    const colorDisplay = document.getElementById('colorDisplay');

    const modal = FlowbiteInstances.getInstance('Modal', currentModalName);

    modal.updateOnShow(() => {

        // Assign the current name of the category
        document.getElementById('catName').value = name;

        // Assign the current color of the category
        let option = document.getElementsByName("catColor")[0].options[0];
        // Assign the color name of the category
        option.text = "Current: " + color;
        option.value = color;
        // Set selected and hidden attributes
        option.setAttribute('selected', true);
        // option.setAttribute('hidden', true);
        // Assign the color name of the category
        colorDisplay.classList.add(selColor);

        // Assign the current category's color value to the select input
        document.getElementById('catColor').value = color;

        // console.log(document.getElementById('catColor').value);

        // Update the modal's form action
        document.getElementById('edit-form').action = route('categories.update', slug);
    });

    // ================================ Color Display ================================
    // Change the color display depending on the selected color from the dropdown list
    document.getElementById('catColor').addEventListener('change', function() {

        colorDisplay.classList.remove(selColor);
        selColor = "bg-"+this.value+"-400";
        colorDisplay.classList.add(selColor);
        // console.log('You selected: ', this.value);
    });

    modal.updateOnHide(() => {

        colorDisplay.classList.remove(selColor);
        // Set the first option to be selected first upon opening the modal again
        document.getElementsByName('catColor')[0].value = 'default';
    });
}


// ================================ Delete Modal Button ================================
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

        if (action == "delete") {

            // console.log(route(type + '.destroy', identifier));

            // Update the modal's form action
            document.getElementById('deletionModalForm').action = route(type + '.destroy', identifier);

        } else if (action == "restore") {

            // console.log(route(type + '.destroy', identifier));

            // Update the modal's form action
            document.getElementById('restorationModalForm').action = route(type + '.restore', identifier);

            // console.log(document.getElementById('restoration-form').action);

        } else if (action == "permaDelete") {

            // console.log(route(type + '.destroy', identifier));

            // Update the modal's form action
            document.getElementById('permaDeletionModalForm').action = route(type + '.erase', identifier);
        }

    });
}
