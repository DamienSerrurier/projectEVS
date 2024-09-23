const divCategory = document.getElementById('category');
const listOptions = document.querySelectorAll('#managementSelect > option');
const menu = document.querySelectorAll('menu > li');
const listLiElement = [...menu];

let displaySize = 1208;

const asyncChoiceCategoryMenu = async function (number) {

    try {
        const response = await fetch(`controllers/administratorSpaceController.php?page=administratorSpace&categoryMenu=${number}`);
    
        if (response.ok) {
            const data = await response.text();
            const parser = new DOMParser();
            const page = parser.parseFromString(data, 'text/html');
            return page;
        }
        else {
            alert(new Error("Retour serveur " + response.status));
        }

    }
    catch (error) {
        alert(new Error('Il y a eu une erreur' + error));
    }
}

const selectElementAllScreen = function (list) {

    list.forEach(element => {
        element.addEventListener('click', function () {
            let categoryValue = element.value; 
            
            asyncChoiceCategoryMenu(categoryValue).then(page => {
                const pageCategory = page.getElementById('category');
                divCategory.innerHTML = pageCategory.innerHTML;
            });
        })
    })
}

listLiElement.forEach(element => {
    element.addEventListener('mouseover', function () {
        element.classList.add("text-bg-secondary");
    })
})

listLiElement.forEach(element => {
    element.addEventListener('mouseleave', function () {
        element.classList.remove("text-bg-secondary");
    })
})

if (window.screen.width <= displaySize) {
    selectElementAllScreen(listOptions);
}
else {
    selectElementAllScreen(listLiElement);
}


