const jsCookie = document.cookie = 'jsEnabled=true';
const divMemberForm = document.getElementById('memberForm');
// console.log(divMemberForm);
const urlCheckboxMember = 'controllers/userSpaceController.php?page=userSpace&checkboxMemberParam=';
const hiddeninput = document.createElement('input');
hiddeninput.type = 'hidden';
hiddeninput.name = 'jsEnabled';
hiddeninput.value = jsCookie;

let checkboxMember = document.getElementById('member');
let selectButtonMember = document.getElementById('responsibleSelect');
let abortController = null;

/**Fonction asynchrone permettant d'attribuer un choix
 * @param {*} url 
 * @param {*} choice 
 * @returns 
 */
const asyncChoiceValue = async function (url, choice) {

    if (abortController && !abortController.signal.aborted) {
        abortController.abort();
        // console.log('abandonné');
    }

    abortController = new AbortController();
    const signal = abortController.signal;

    try {
        let response = await fetch(`${url}${choice}`, { signal });

        if (response.ok) {
            const data = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, 'text/html');
            return doc;
        } else {
            console.error(new Error("Retour serveur " + response.status));
            alert("Une erreur serveur est survenue. Veuillez vérifier votre connexion ou réessayer.");
        }
    } catch (error) {

        if (error.name == 'AbortError') {
            console.warn("Requête annulée.");
        }
        else {
            console.error(new Error("Il y a eu une erreur " + error));
            alert("Une erreur réseau s'est produite. Veuillez réessayer.")
        }
    }
};

const inputName = (idInput) => {
    
    const element = document.getElementById(idInput);

    if (!element) {
        console.warn(`L'élément avec l'ID "${idInput}" n'existe pas.`);
    }

    return element;
};

const changeColor = function (number, event) {
    const regexText = /^[a-zA-Z- éèêôâàîïùûç]+$/;
    const regexMail = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    const regexPhone = /^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/;
    const regexNumber = /^\d+\s?[a-zA-Z\s]*$/;
    const regexComplementAddress = /^[\w\s-]*$/;
    const regexZipeCodeAddress = /^\d{5}$/;
    const regexCaf = /^[0-9]{7}[A-Z]$/;

    let target = event.target;
    let id = target.id;
    // console.log(id);
    let value = target.value;

    // console.log('changeColor ok');
    /**Fonction permettant d'attribuer un code couleur à un champ en fonction d'une bonne ou mauvaise information
     * @param {*} regex 
     * @param {*} memberData 
     */
    let colorCodeRegex = function(regex, memberData) {
        // console.log('colorCodeRegex ok');
        if (regex.test(value)) {
            memberData.style.border = '2px solid green';
        } else {
            memberData.style.border = '2px solid red';
        }
    }

    if (id.startsWith('memberLastname' + number)) {
        const memberLastname = inputName(`memberLastname${number}`);

        colorCodeRegex(regexText, memberLastname);

    } else if (id.startsWith('memberFirstname' + number)) {
        const memberFirstname = inputName(`memberFirstname${number}`);
        
        colorCodeRegex(regexText, memberFirstname);

    } else if (id.startsWith('memberMail' + number)) {
        const memberMail = inputName(`memberMail${number}`);

        if (memberMail.value === '') {
            memberMail.style.border = '2px solid green';
        } else {
            colorCodeRegex(regexMail, memberMail);
        }
    } else if (id.startsWith('memberPhone' + number)) {
        const memberPhone = inputName(`memberPhone${number}`);

        if (value === '') {
            memberPhone.style.border = '2px solid green';
        } else {
            colorCodeRegex(regexPhone, memberPhone);  
        }
    } else if (id.startsWith('memberBirthdate' + number)) {
        const memberBirthdate = inputName(`memberBirthdate${number}`);

        let dateToday = Date.now();
        let birthdate = new Date(value).getTime();

        if (birthdate < dateToday) {
            memberBirthdate.style.border = '2px solid green';
        } else {
            memberBirthdate.style.border = '2px solid red';
        }
    } else if (id.startsWith('memberBirthPlace' + number)) {
        const memberBirthPlace = inputName(`memberBirthPlace${number}`);

        colorCodeRegex(regexText, memberBirthPlace);

    } else if (id.startsWith('memberStreetNumber' + number)) {
        const memberStreetNumber = inputName(`memberStreetNumber${number}`);

        if (value === '') {
            memberStreetNumber.style.border = '2px solid green';
        } else {
            if (value !== 0) {
                colorCodeRegex(regexNumber, memberStreetNumber);
            } else {
                memberStreetNumber.style.border = '2px solid red';
            }
        }
    } else if (id.startsWith('memberStreetName' + number)) {
        const memberStreetName = inputName(`memberStreetName${number}`);

        colorCodeRegex(regexText, memberStreetName);
        
    } else if (id.startsWith('memberStreetComplement' + number)) {
        const memberStreetComplement = inputName(`memberStreetComplement${number}`);

        colorCodeRegex(regexComplementAddress, memberStreetComplement);

    } else if (id.startsWith('memberZipCode' + number)) {
        const memberZipCode = inputName(`memberZipCode${number}`);

        colorCodeRegex(regexZipeCodeAddress, memberZipCode);

    } else if (id.startsWith('memberCity' + number)) {
        const memberCity = inputName(`memberCity${number}`);

        colorCodeRegex(regexText, memberCity);

    } else if (id.startsWith('profession' + number)) {
        const profession = inputName(`profession${number}`);

        if (profession.value === '') {
            profession.style.border = '2px solid green';
        } else {
            colorCodeRegex(regexText, profession);     
        }
    } else if (id.startsWith('familySituation' + number)) {
        const familySituation = inputName(`familySituation${number}`);

        if (value === '') {
            familySituation.style.border = '2px solid green';
        } else {
            colorCodeRegex(regexText, familySituation);  
        }
    } else if (id.startsWith('cafNumber' + number)) {
        const cafNumber = inputName(`cafNumber${number}`);

        colorCodeRegex(regexCaf, cafNumber);
    }
}

/**Fonction permettant de définir un code couleur indiquant à l'utilisateur les bonnes informations renseignées pour chaque formulaire
 * @param {*} number 
 */
const inputsBlur = function(number) {
    divMemberResponsible = document.getElementById('memberResponsible');

    // console.log(divMemberResponsible);
    for (let i = 1; i <= number; i++) {
        divMemberResponsible.addEventListener('blur', function (event) {
            changeColor(i, event);
        }, true)
    }
};

const handleSubmit = function (formValid, url, value) {
    // console.log('callback');

   
    const submitButton = formValid.querySelector('input[name="createMember"]');
    
    let isFormValid = false;

    return async (event) => {
        event.preventDefault();

        isFormValid = formValid.checkValidity();
        
        // console.log(event.target);
        // console.log('retour de fonction annonyme');
        
        // console.log(formValid);
        try {
            let formData = new FormData(formValid);
            formData.append(submitButton.name, submitButton.value);
            // console.log(formData);
            
            const response = await fetch(`${url}${value}`, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const text = await response.text();
                // console.log(text);
            
                const myHeader = new Headers(response.headers);
                const headerJson = myHeader.get('Content-Type');
                // console.log(headerJson);
                    
                try {
                    
                    if (headerJson == 'application/json') {
                        // console.log(myHeader);

                        const result = JSON.parse(text);
                        // console.log(result);
                    
                        if (result.status === 'error') {
                            isFormValid = false;
                            
                            const pErrors = document.querySelectorAll('.error-message');
    
                            pErrors.forEach(element => {
                                element.textContent = "";
                            })
    
                            for (let i = 1; i <= value; i++) {
    
                                if (result.messages[i]) {
                                    
                                    for (const [key, value] of Object.entries(result.messages[i])) {
                                        const elementError = document.getElementById('error-' + key);
    
                                        // console.log("La clef est " + key + ' et la valeur est ' + value);
                                        
                                        if (elementError) {
                                            elementError.textContent = value;
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            const divMessage = document.getElementById('message');

                            if (divMessage) {
                                const createP = document.createElement('p');
                                createP.setAttribute('class', 'text-success');
                                // console.log(createP);
                                divMessage.append(createP);
                                createP.textContent = result.message;
                            }
                        }
                    }
                }
                catch (e) {
                    console.warn("La réposonse n'est pas en JSON " + text);
                    isFormValid = true;
                    
                }
            }
            else {
                console.error(new Error("Retour serveur " + response.status));
                isFormValid = false;
            }
        }
        catch (error) {
            console.error(new Error("Il y a eu une erreur " + error));
            isFormValid = false;
        }

        if (isFormValid) {
            console.info("Le formulaire est valide et soumis.");
            formValid.submit();
        }
        else {
            console.warn("Le formulaire invalide.");
        }
    };
};
    
const resetInput = function () {
    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
        const pErrorMessage = form.querySelector('p#error-' + input.name);
        
        const resetParagraph = function () {
            pErrorMessage.textContent = "";
        }

        if (input['type'] == 'radio' || input['type'] == 'date') {

            input.addEventListener('change', resetParagraph);
        }
        else {
            input.addEventListener('keypress', resetParagraph);
        }
    })
}

const choiceNumberMember = async function (event) {
    const divMemberResponsible = document.getElementById('memberResponsible');

    let numberChoice = event.value

    if (divMemberResponsible) {
        const pInfo = document.getElementById('info');
        const textNumberOfResponsible = "Veuillez faire un choix du nombre de responsable.";
        const infoText = document.createTextNode(textNumberOfResponsible);
        // console.log(pInfo);
        
        if (event.value == 0) {
            // console.log(event.value);
            pInfo.append(infoText);
            divMemberResponsible.innerHTML = "";
            
        }
        else {
    
            if (event && event.value !== undefined && event.value > 0 && event.value <= 2) {
                // console.log(event.value);
                const urlSelectButtonNumber = `${urlCheckboxMember}${checkboxMember.checked}&numberResponsible=`;
                const form = document.forms['form'];
                // console.log(form);
                
                form.appendChild(hiddeninput);
                const callbackHandleSubmit = handleSubmit(form, urlSelectButtonNumber, numberChoice);
                // console.log(callbackHandleSubmit);

                try {
                    const page = await asyncChoiceValue(urlSelectButtonNumber, numberChoice);
    
                    if (page) {
                        // console.log(page);
                        // console.log(event.value);
                        const pageDivMemberResponsible = page.getElementById('memberResponsible');
                        // console.log(pageDivMemberResponsible);
                        pInfo.textContent = "";

                        if (pageDivMemberResponsible) {
                            divMemberResponsible.innerHTML = pageDivMemberResponsible.innerHTML;
                            inputsBlur(numberChoice);
                            resetInput();
    
                            form.addEventListener('submit', callbackHandleSubmit);
    
                            event.addEventListener('change', ()=> { form.removeEventListener('submit', callbackHandleSubmit)});
                        }
                    }
                    

                }
                catch (error) {
                    console.error("Erreur :", error)
                }
            }
        }
    }
}

const updateChoiceMember = function () {
    selectButtonMember = document.getElementById('responsibleSelect');

    if (selectButtonMember) {

        if (selectButtonMember.value > 0) {
            choiceNumberMember(selectButtonMember);
        }

        selectButtonMember.addEventListener('change', function () {
            choiceNumberMember(selectButtonMember);
        });
        
    }
}

const checkbox = async function (event) {
    // console.log(event);
    // console.log(checkboxMember.checked);

    if (checkboxMember.checked) {
        // console.log('coché');
        divMemberForm.style.display = 'block';

        const page = await asyncChoiceValue(urlCheckboxMember, checkboxMember.checked);

        try {

            if (page) {
                // console.log(page);
                const divPageMemberForm = page.getElementById('memberForm');
                
                if (divPageMemberForm) {
                    // console.log(divPageMemberForm);
                    divMemberForm.innerHTML = divPageMemberForm.innerHTML;
                    updateChoiceMember();
                }
            }
        }
        catch (error) {
            console.error("Erreur :", error);
        }
    }
    else {
        divMemberForm.style.display = 'none';
    }
}

const start = function (event) {
    // console.log(event);
    
    if(checkboxMember) {

        if (selectButtonMember != null) {
            checkbox();
        }

        checkboxMember.addEventListener('change', checkbox);
        // console.log(checkbox);
    }
    
}

document.addEventListener('DOMContentLoaded', start);

