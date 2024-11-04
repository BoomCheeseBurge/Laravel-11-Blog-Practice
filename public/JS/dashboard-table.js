
// ================================ Sluggable Input ================================
const title = document.getElementById('title');
const slug = document.getElementById('slug');

title.addEventListener('change', () => fetch(route('posts.slug', title.value)).then((response) => response.json()).then((data) => slug.value = data.slug));

// ================================ Featured Image Upload ================================
function imageData() {
    return {
      previewUrl: "",
      updatePreview() {
        var reader,
          files = document.getElementById("featured_image").files;

        reader = new FileReader();

        reader.onload = e => {
          this.previewUrl = e.target.result;
        };

        reader.readAsDataURL(files[0]);
      },
      clearPreview() {
        document.getElementById("featured_image").value = null;
        this.previewUrl = "";
      }
    };
  }

// ================================ Disable Link Attachment from Trix Editor ================================
document.addEventListener('trix-file-accept', (e) => { e.preventDefault() });

// ================================ Hide Link Attachment from Trix Editor ================================
// Guarantees that the script executes only after the DOM is ready
// document.addEventListener('DOMContentLoaded', () => {
//     const uploadButton = document.querySelector('[data-trix-action="attachFiles"]');
//     if (uploadButton) {
//         uploadButton.style.display = 'none';
//     }
//     const fileTools = document.querySelector('[data-trix-button-group="file-tools"]');
//     if (fileTools) {
//         fileTools.style.display = 'none';
//     }

//     // const elements = document.querySelectorAll('.trix-button');
//     // elements.forEach(element => {
//     //     if (element.classList.contains('trix-button')) {
//     //       element.classList.add('dark:bg-white');
//     //     }
//     //   });
// });
