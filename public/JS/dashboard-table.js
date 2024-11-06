
// ================================ Pass Data to Modal ================================

        // attach click event listener to parent element
        document.getElementById("container").addEventListener("click", function (event) {
            // check if target element is an img with the upload_image class
            if (event.target && event.target.matches("img.upload_image")) {
                imageSelect(event);
            }
        });

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
