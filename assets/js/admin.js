let menu = document.querySelectorAll('menu > li');
let listLi = [...menu];

listLi.forEach(element => {
    element.addEventListener('mouseover', function () {
        element.classList.add("text-bg-secondary");
    })
})

listLi.forEach(element => {
    element.addEventListener('mouseleave', function () {
        element.classList.remove("text-bg-secondary")
    })
})

