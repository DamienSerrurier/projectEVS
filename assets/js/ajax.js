const divMemberResponsible = document.getElementById('memberResponsible');
const pInfo = document.getElementById('info');
const textnumberOfResponsible = "Veuillez faire un choix du nombre de responsable";
const infoText = document.createTextNode(textnumberOfResponsible);

const regexText = /^[a-zA-Z- éèêôâàîïùûç]+$/;
const regexMail = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
const regexPhone = /^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/;
const regexNumber = /^\d+\s?[a-zA-Z\s]*$/;
const regexComplementAddress = /^[\w\s-]*$/;
const regexZipeCodeAddress = /^\d{5}$/;
const regexCaf = /^[0-9]{7}[A-Z]$/;

let responsibleSelect = document.getElementById('responsibleSelect');
let sessionResponsibleValue = responsibleSelect.value;

/**Fonction asynchrone permettant d'attribuer un nombre de responsable
 * @param {*} responsibleValue 
 * @returns doc
 */
let asyncChoiceNumberMember = async function (responsibleValue) {

    try {
        let response = await fetch(`controllers/userSpaceController.php?page=userSpace&responsible=${responsibleValue}`);

        if (response.ok) {
            let data = await response.text();
            const parser = new DOMParser();
            doc = parser.parseFromString(data, 'text/html');
            return doc;
        } else {
            alert(new Error("Retour serveur" + response.status));
        }
    } catch (error) {
        alert(new Error("Il y a eu une error" + error));
    }
};

/**Fonction permettant de définir un code couleur indiquant à l'utilisateur les bonnes informations renseignées pour chaque formulaire
 * @param {*} number 
 */
let inputsBlur = function(number) {

    for (let i = 1; i <= number; i++) {

        divMemberResponsible.addEventListener('blur', function (event) {
            let target = event.target;
            let id = target.id;
            let value = target.value;
    
            /**Fonction permettant d'attribuer un code couleur à un champ en fonction d'une bonne ou mauvaise information
             * @param {*} regex 
             * @param {*} memberData 
             */
            let colorCodeRegex = function(regex, memberData) {

                if (regex.test(value)) {
                    memberData.style.border = '2px solid green';
                } else {
                    memberData.style.border = '2px solid red';
                }
            }

            if (id.startsWith('memberLastname' + i)) {
                const memberLastname = document.getElementById('memberLastname' + i);
    
                colorCodeRegex(regexText, memberLastname);

            } else if (id.startsWith('memberFirstname' + i)) {
                const memberFirstname = document.getElementById('memberFirstname' + i);
    
                colorCodeRegex(regexText, memberFirstname);

            } else if (id.startsWith('memberMail' + i)) {
                const memberMail = document.getElementById('memberMail' + i);
    
                if (memberMail.value == '') {
                    memberMail.style.border = '2px solid green';
                } else {
                    colorCodeRegex(regexMail, memberMail);
                }
            } else if (id.startsWith('memberPhone' + i)) {
                const memberPhone = document.getElementById('memberPhone' + i);
    
                if (value == '') {
                    memberPhone.style.border = '2px solid green';
                } else {
                    colorCodeRegex(regexPhone, memberPhone);  
                }
            } else if (id.startsWith('memberBirthdate' + i)) {
                const memberBirthdate = document.getElementById('memberBirthdate' + i);
                let dateToday = Date.now();
                let birthdate = new Date(value).getTime();
    
                if (birthdate < dateToday) {
                    memberBirthdate.style.border = '2px solid green';
                } else {
                    memberBirthdate.style.border = '2px solid red';
                }
            } else if (id.startsWith('memberBirthPlace' + i)) {
                const memberBirthPlace = document.getElementById('memberBirthPlace' + i);
    
                colorCodeRegex(regexText, memberBirthPlace);

            } else if (id.startsWith('memberStreetNumber' + i)) {
                const memberStreetNumber = document.getElementById('memberStreetNumber' + i);
    
                if (value == '') {
                    memberStreetNumber.style.border = '2px solid green';
                } else {
                    if (value != 0) {
                        colorCodeRegex(regexNumber, memberStreetNumber);
                    } else {
                        memberStreetNumber.style.border = '2px solid red';
                    }
                }
            } else if (id.startsWith('memberStreetName' + i)) {
                const memberStreetName = document.getElementById('memberStreetName' + i);
    
                colorCodeRegex(regexText, memberStreetName);
                
            } else if (id.startsWith('memberStreetComplement' + i)) {
                const memberStreetComplement = document.getElementById('memberStreetComplement' + i);
    
                colorCodeRegex(regexComplementAddress, memberStreetComplement);

            } else if (id.startsWith('memberZipCode' + i)) {
                const memberZipCode = document.getElementById('memberZipCode' + i);
    
                colorCodeRegex(regexZipeCodeAddress, memberZipCode);

            } else if (id.startsWith('memberCity' + i)) {
                const memberCity = document.getElementById('memberCity' + i);
    
                colorCodeRegex(regexText, memberCity);

            } else if (id.startsWith('profession' + i)) {
                const profession = document.getElementById('profession' + i);
    
                if (profession.value == '') {
                    profession.style.border = '2px solid green';
                } else {
                    colorCodeRegex(regexText, profession);     
                }
            } else if (id.startsWith('familySituation' + i)) {
                const familySituation = document.getElementById('familySituation' + i);
    
                if (value == '') {
                    familySituation.style.border = '2px solid green';
                } else {
                    colorCodeRegex(regexText, familySituation);  
                }
            } else if (id.startsWith('cafNumber' + i)) {
                const cafNumber = document.getElementById('cafNumber' + i);
    
                colorCodeRegex(regexCaf, cafNumber);
            }
        }, true)
    }
};

if (sessionResponsibleValue > 0) {
    pInfo.innerHTML = "";
} 
else {
    pInfo.append(infoText);
}


inputsBlur(sessionResponsibleValue);

//Ecouteur d'événement sur le bouton select
responsibleSelect.addEventListener('change', function () {
    let responsibleValue;
    responsibleValue = parseInt(responsibleSelect.value);

    //Vérifie si la valeur est égale à 0 et réinitialise l'élément div du formulaire
    if (responsibleValue === 0) {
        divMemberResponsible.innerHTML = '';
        pInfo.innerHtml = pInfo.innerHTML = textnumberOfResponsible;
    }
    else {
        //Vérifie si c'est un nombre et que ce nombre soit à la fois plus grand que 0 et plus petit ou égale à 2 
        if (!isNaN(responsibleValue && responsibleValue > 0 && responsibleValue <= 2)) {
    
            asyncChoiceNumberMember(responsibleValue).then(doc => {
                const docMemberResponsible = doc.querySelector('#memberResponsible');
                const docInfo = doc.getElementById('info');
                divMemberResponsible.innerHTML = docMemberResponsible.innerHTML;
                pInfo.innerHTML =  docInfo.innerHtml = "";
            });
        }
    }

    inputsBlur(responsibleValue);
})