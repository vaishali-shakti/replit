// add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");
let close = document.querySelector(".close-btn"); // Ensure that '.close-btn' is the correct class for your close button

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

close.onclick = function () {
  navigation.classList.remove("active");
  main.classList.remove("active");
};
