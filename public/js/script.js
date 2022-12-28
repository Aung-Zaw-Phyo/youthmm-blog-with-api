const menuContainerTag = document.querySelector('.menuContainer');
const line1Tag = document.querySelector('.line1');
const line2Tag = document.querySelector('.line2');
const line3Tag = document.querySelector('.line3');
const overlayTag = document.querySelector('.overlay');

menuContainerTag.addEventListener("click", ()=>{
    if (menuContainerTag.classList.contains("opened")) {
        line2Tag.classList.remove("remove")
        line1Tag.classList.remove("line1Deg")
        line3Tag.classList.remove("line3Deg")
        menuContainerTag.classList.remove("opened");
        overlayTag.classList.remove("opacityAndZindex")
    } else {
        line2Tag.classList.add("remove")
        line1Tag.classList.add("line1Deg")
        line3Tag.classList.add("line3Deg")
        menuContainerTag.classList.add("opened")
        overlayTag.classList.add("opacityAndZindex")

    }
});

const navUpDown = document.querySelector('.navUpDown');
// window.addEventListener("scroll", ()=>{
//     if (window.pageYOffset>100) {
//         navUpDown.style.top="0px";
//     } else {
//         navUpDown.style.top="30px";
//     }
// });
