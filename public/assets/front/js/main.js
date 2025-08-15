let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
arrow[i].addEventListener("click", (e)=>{
let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
arrowParent.classList.toggle("showMenu");
});
}

// let sidebar = document.querySelector(".sidebar");
// let sidebarBtn = document.querySelector(".toogle_btn");
// console.log(sidebarBtn);
// sidebarBtn.addEventListener("click", ()=>{
// sidebar.classList.toggle("close");
// });

// ------------- dropdown menu -------------

// const dropdownContent = document.querySelector(".action-dropdown");
// const chevron = document.getElementById("chevron");

// function showMenu() {
//   dropdownContent.classList.toggle("active");
//   chevron.classList.toggle("rotate");
// }

// window.onclick = (event) => {
//   // Check if the clicked target is not the dropdown button or inside the dropdown
//   if (!event.target.closest(".action-dropdown-button") &&
//       !event.target.closest(".action-dropdown")) {
//     dropdownContent.classList.remove("active");
//     chevron.classList.remove("rotate");
//   }
// };

const dropdownButtons = document.querySelectorAll('.action-dropdown-button');

dropdownButtons.forEach(button => {
  button.addEventListener('click', function() {
    const dropdownContent = this.nextElementSibling; // Get corresponding dropdown content
    const chevron = this.querySelector('.action-chevron-icon');

    // Toggle active state for the clicked dropdown and chevron
    dropdownContent.classList.toggle('active');
    chevron.classList.toggle('rotate');

    // Close other dropdowns (optional behavior)
    dropdownButtons.forEach(otherButton => {
      if (otherButton !== this) {
        const otherDropdownContent = otherButton.nextElementSibling;
        const otherChevron = otherButton.querySelector('.action-chevron-icon');
        otherDropdownContent.classList.remove('active');
        otherChevron.classList.remove('rotate');
      }
    });
  });
});

window.onclick = (event) => {
  // Close dropdown if clicked outside
  if (!event.target.closest('.action-dropdown-button') && !event.target.closest('.action-dropdown')) {
    dropdownButtons.forEach(button => {
      const dropdownContent = button.nextElementSibling;
      const chevron = button.querySelector('.action-chevron-icon');
      dropdownContent.classList.remove('active');
      chevron.classList.remove('rotate');
    });
  }
};


// ------------ notification bell -------------
function addClass(notification_box, active) {
  const element = document.querySelector('.notification_box');
  if (element) {
      element.classList.add("active");
  }
}
function removeClass(notification_box, active) {
  const element = document.querySelector('.notification_box');
  if (element) {
    element.classList.remove("active");
  }
}
