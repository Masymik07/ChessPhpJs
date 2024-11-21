let element = document.querySelector(".ikona")
element.addEventListener("click", wysunMenu);

function wysunMenu(){
    element.style.marginRight="300px"
    element.removeEventListener("click", wysunMenu);
    element.addEventListener("click", wysunMenu1);
}

function wysunMenu1(){
    element.style.marginRight="-300px"
    element.removeEventListener("click", wysunMenu1);
    element.addEventListener("click", wysunMenu);
}