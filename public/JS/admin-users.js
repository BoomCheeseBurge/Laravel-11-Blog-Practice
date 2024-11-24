
// ================================ Check Reentered Password Matches ================================

function match() {
    const passInput = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    let matchMsg = document.getElementById('matchMessage');

    if (passInput.value || confirmPassword.value) {
        // Apply styling and text based on password match
        if (passInput.value === confirmPassword.value) {
        //   matchMsg.style.color = 'green';
            matchMsg.classList.add("text-green-400", "dark:text-teal-300");
            matchMsg.classList.remove("text-red-500", "dark:text-rose-300");
            matchMsg.innerText = 'Password match';
        } else {
            // matchMsg.style.color = 'red';
            matchMsg.classList.add("text-red-500", "dark:text-rose-300");
            matchMsg.classList.remove("text-green-400", "dark:text-teal-300");
            matchMsg.innerText = 'Password mismatch';
        }
    } else {
        // Clear styling and text if no input
        // matchMsg.style.color = ''; // Reset color
        matchMsg.classList.remove("text-green-400", "dark:text-teal-300", "text-red-500", "dark:text-rose-300");
        matchMsg.innerText = '';  // Empty text
      }
    };

// ================================ Check for Mismatch Password ================================
const form = document.getElementById('registrationForm');

form.addEventListener('submit', (event) => {

  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirmPassword').value;

  if (password !== confirmPassword) {
    event.preventDefault();
    alert('Passwords do not match. Please try again.');
  }
});

// ================================ Reset the file input values ================================
document.addEventListener("DOMContentLoaded", (event) => {

    const profileInput = document.getElementById('profile_pic');
    const coverInput = document.getElementById('profile_cover');

    profileInput.value = "";
    coverInput.value = "";
});

// ================================ Check for Uploaded Profile Image ================================
function handleImageChange(input)
{
    const imgPreview = document.getElementById('profile_preview');
    const defaultIMG = document.getElementById('profile_default');

    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        reader.onload = function(e) {

            imgPreview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);

        defaultIMG.classList.remove('hidden');
    }
}

function profileDefault()
{
    const defaultIMG = document.getElementById('profile_default');
    const imgPreview = document.getElementById('profile_preview');
    const fileInput = document.getElementById('profile_pic');

    defaultIMG.classList.add('hidden');

    imgPreview.src = "/storage/IMG/default/default_user.png";

    fileInput.value = "";
}

// ================================ Check for Uploaded Cover Photo ================================
function handleCoverChange(input)
{
    const imgPreview = document.getElementById('cover_preview');
    const defaultIMG = document.getElementById('cover_default');

    if (input.files && input.files[0])
    {
        var reader = new FileReader();

        reader.onload = function(e) {

            imgPreview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);

        defaultIMG.classList.remove('hidden');
    }
}

function coverDefault()
{
    const defaultIMG = document.getElementById('cover_default');
    const imgPreview = document.getElementById('cover_preview');
    const fileInput = document.getElementById('profile_cover');

    defaultIMG.classList.add('hidden');

    imgPreview.src = "/storage/IMG/default/default_background.jpeg";

    fileInput.value = "";
}
