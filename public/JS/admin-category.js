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

            if (colorChange) {
                colorDisplay2.classList.remove(colorChange);
            }
            selColor = "bg-"+this.value+"-400";
            colorDisplay2.classList.add(selColor);
            colorChange = selColor;
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
/**
 *
 *
 * @param {string} slug
 * @param {string} name
 * @param {string} color
 */
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

        // Update the modal's form action
        document.getElementById('edit-form').action = route('categories.update', slug);
    });

    // ================================ Color Display ================================
    // Change the color display depending on the selected color from the dropdown list
    document.getElementById('catColor').addEventListener('change', function() {

        colorDisplay.classList.remove(selColor);
        selColor = "bg-"+this.value+"-400";
        colorDisplay.classList.add(selColor);
    });

    modal.updateOnHide(() => {

        colorDisplay.classList.remove(selColor);
        // Set the first option to be selected first upon opening the modal again
        document.getElementsByName('catColor')[0].value = 'default';
    });
}


// ================================ Delete Modal Button ================================
/**
 *
 *
 * @param {string} identifier
 * @param {string} type
 * @param {string} action
 */
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

            // Update the modal's form action
            document.getElementById('deletionModalForm').action = route(type + '.destroy', identifier);

        } else if (action == "restore") {

            // Update the modal's form action
            document.getElementById('restorationModalForm').action = route(type + '.restore', identifier);

        } else if (action == "permaDelete") {

            // Update the modal's form action
            document.getElementById('permaDeletionModalForm').action = route(type + '.erase', identifier);
        }

    });
}

// --------------------------------------------------------------------------------------------------------------------------------

// ================================ Featured Image Upload ================================
function imageData(image = '') {

    return {
      previewUrl: image,
      updatePreview() {
        var reader,
          files = document.getElementById("image").files;

        reader = new FileReader();

        reader.onload = e => {
          this.previewUrl = e.target.result;
        };

        reader.readAsDataURL(files[0]);
      },
      clearPreview() {
        document.getElementById("image").value = null;
        this.previewUrl = "";
      }
    };
  }


  function catImageData() {

    return {
      updatePreview() {
        var reader,
          files = document.getElementById("catImage").files;

        reader = new FileReader();

        reader.onload = e => {
          this.fileExist = e.target.result;
        };

        reader.readAsDataURL(files[0]);
      },
      clearPreview() {
        document.getElementById("catImage").value = null;
        this.fileExist = "";
      }
    };
  }
