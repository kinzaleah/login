
//first I want to select my burger button
const burgerButton = document.querySelector(".burger-button");

console.log(burgerButton);


//then onclick, run a function to toggle class - addeventlistener then an anonymous function

burgerButton.addEventListener("click", function() {
    const sideMenu = document.querySelector(".js-side-menu");
    sideMenu.classList.toggle("hidden");
});