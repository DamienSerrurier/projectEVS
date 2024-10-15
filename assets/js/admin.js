document.addEventListener('DOMContentLoaded', function () {
    const divCategory = document.getElementById('category');
    const listOptions = document.querySelectorAll('#managementSelect > option');
    const menu = document.querySelectorAll('menu > li');
    const listLiElement = [...menu];
    const url = new URL(document.location.href);
    const param = new URLSearchParams(url.search);
    const categoryMenuId = param.get('categoryMenu');
    const errorMessageCategory = document.getElementById('errorMessageCategory');
    
    let displaySize = 1208;

    // const state = {
    //     valueParamMenu: `&categoryMenu=${categoryValue}`,
    //     valueSelectButtonCategory: `&selectButtonValue=${selectButtonValue}`
    // };

    // const title = "";
    // const urlMenu = 'administratorSpace' + state.valueParamMenu;
    // const urlSelectButtonCategory = 'administratorSpace' + state.valueParamMenu + state.valueSelectButtonCategory;
    
    const asyncChoiceCategoryMenuAndSelectButtons = async function (url, number) {
    
        try {
            const response = await fetch(`${url}${number}`);
        
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

    const changeListener = async function(categoryMenuId) {
        const selectButtonCategories = document.getElementById('categorySelect');
        const inputCategoryName = document.getElementById('categoryName');
       
        if (selectButtonCategories) {
    
            selectButtonCategories.addEventListener('change', async function () {
                const urlSelectButtonCategory = `controllers/administratorSpaceController.php?page=administratorSpace&categoryMenu=${categoryMenuId}&selectButtonValue=`;
                const selectButtonValue = selectButtonCategories.value;

                if (errorMessageCategory) {
                    errorMessageCategory.textContent = "";
                }

                asyncChoiceCategoryMenuAndSelectButtons(urlSelectButtonCategory, selectButtonValue).then(page => {
                    const pageInputCategoryName = page.getElementById('categoryName');

                    if (selectButtonCategories.value != '') {
                        console.log(pageInputCategoryName);
                        inputCategoryName.value = pageInputCategoryName.value;
                    }
                    else {
                        inputCategoryName.value = '';
                    }
                });
            })
        }
    }

    changeListener(categoryMenuId);
  
    const selectElementAllScreen = async function (list) {
    
        list.forEach(element => {
            element.addEventListener('click', function () {
                const urlCategoryMenu = 'controllers/administratorSpaceController.php?page=administratorSpace&categoryMenu=';
                categoryValue = element.value; 
                
                asyncChoiceCategoryMenuAndSelectButtons(urlCategoryMenu, categoryValue).then(page => {
                    const pageCategory = page.getElementById('category');
                    divCategory.innerHTML = pageCategory.innerHTML;
    
                    switch (categoryValue) {
                        case 1:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            break;
                            
                        case 2:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            break;
                            
                        case 3:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            changeListener(categoryValue);
                            break;
    
                        case 4:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            break;
    
                        case 5:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            break;
    
                        case 6:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            break;
    
                        default:
                            // history.replaceState(state, title, url);
                            console.log('ok' + categoryValue);
                            break;
                    }
                });
            })
        })
    }
    
    if (window.screen.width <= displaySize) {
        selectElementAllScreen(listOptions);
    }
    else {

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

        selectElementAllScreen(listLiElement);
    }
})





