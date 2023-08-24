const divMemberResponsible = document.getElementById('memberResponsible');
const responsibleSelect = document.getElementById('responsibleSelect');

let asyncChoiceNumberMember = async function (responsibleValue) {

    try {
        let response = await fetch(`controllers/userSpaceController.php?page=userSpace&responsible=${responsibleValue}`)

        if (response.ok) {
            let data = await response.text();
            let parser = new DOMParser();
            doc = parser.parseFromString(data, 'text/html');
            return doc;
        } else {
            alert(new Error("Retour serveur" + response.status));
        }
    } catch (error) {
        alert(new Error("Il y a eu une error" + error));
    }
}

responsibleSelect.addEventListener('change', function () {
    let responsibleValue = parseInt(responsibleSelect.value);

    if (responsibleValue === 0) {

        divMemberResponsible.innerHTML = '';
        responsibleSelect = 0;
        
    }
    if (!isNaN(responsibleValue && responsibleValue > 0 && responsibleValue <= 2)) {

        asyncChoiceNumberMember(responsibleValue).then(doc => {
            const docMemberResponsible = doc.querySelector('#memberResponsible');
            divMemberResponsible.innerHTML = docMemberResponsible.innerHTML;
        });
    } else {
        alert(new Error("Veuillez faire un choix"));
    }

    const regexText = /^[a-zA-Z- éèêôâàîïùûç]+$/;
    const regexMail = /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    const regexPhone = /^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/;
    const regexNumber = /^\d+\s?[a-zA-Z\s]*$/;
    const regexComplementAddress = /^[\w\s-]*$/;
    const regexZipeCodeAddress = /^\d{5}$/;
    const regexCaf = /^[0-9]{7}[A-Z]$/;

    for (let i = 1; i <= responsibleValue; i++) {

        divMemberResponsible.addEventListener('blur', function (event) {

            let target = event.target;
            let id = target.id;
            let value = target.value;

            if (id.startsWith('memberLastname' + i)) {
                const memberLastname = document.getElementById('memberLastname' + i);

                if (regexText.test(value)) {
                    memberLastname.style.border = '2px solid green';
                } else {
                    memberLastname.style.border = '2px solid red';
                }

            } else if (id.startsWith('memberFirstname' + i)) {
                const memberFirstname = document.getElementById('memberFirstname' + i);

                if (regexText.test(value)) {
                    memberFirstname.style.border = '2px solid green';
                } else {
                    memberFirstname.style.border = '2px solid red';
                }
            } else if (id.startsWith('memberMail' + i)) {
                const memberMail = document.getElementById('memberMail' + i);

                if (memberMail.value == '') {
                    memberMail.style.border = '2px solid green';
                } else {

                    if (regexMail.test(value)) {
                        memberMail.style.border = '2px solid green';
                    } else {
                        memberMail.style.border = '2px solid red';
                    }
                }
            } else if (id.startsWith('memberPhone' + i)) {
                const memberPhone = document.getElementById('memberPhone' + i);

                if (value == '') {
                    memberPhone.style.border = '2px solid green';
                } else {

                    if (regexPhone.test(value)) {
                        memberPhone.style.border = '2px solid green';
                    } else {
                        memberPhone.style.border = '2px solid red';
                    }
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

                if (regexText.test(value)) {
                    memberBirthPlace.style.border = '2px solid green';
                } else {
                    memberBirthPlace.style.border = '2px solid red';
                }
            } else if (id.startsWith('memberStreetNumber' + i)) {
                const memberStreetNumber = document.getElementById('memberStreetNumber' + i);

                if (value == '') {
                    memberStreetNumber.style.border = '2px solid green';
                } else {
                    if (value != 0) {

                        if (regexNumber.test(value)) {
                            memberStreetNumber.style.border = '2px solid green';
                        } else {
                            memberStreetNumber.style.border = '2px solid red';
                        }
                    } else {
                        memberStreetNumber.style.border = '2px solid red';
                    }
                }
            } else if (id.startsWith('memberStreetName' + i)) {
                const memberStreetName = document.getElementById('memberStreetName' + i);

                if (regexText.test(value)) {
                    memberStreetName.style.border = '2px solid green';
                } else {
                    memberStreetName.style.border = '2px solid red';
                }
            } else if (id.startsWith('memberStreetComplement' + i)) {
                const memberStreetComplement = document.getElementById('memberStreetComplement' + i);

                if (regexComplementAddress.test(value)) {
                    memberStreetComplement.style.border = '2px solid green';
                } else {
                    memberStreetComplement.style.border = '2px solid red';
                }
            } else if (id.startsWith('memberZipCode' + i)) {
                const memberZipCode = document.getElementById('memberZipCode' + i);

                if (regexZipeCodeAddress.test(value)) {
                    memberZipCode.style.border = '2px solid green';
                } else {
                    memberZipCode.style.border = '2px solid red';
                }
            } else if (id.startsWith('memberCity' + i)) {
                const memberCity = document.getElementById('memberCity' + i);

                if (regexText.test(value)) {
                    memberCity.style.border = '2px solid green';
                } else {
                    memberCity.style.border = '2px solid red';
                }
            } else if (id.startsWith('profession' + i)) {
                const profession = document.getElementById('profession' + i);

                if (profession.value == '') {
                    profession.style.border = '2px solid green';
                } else {
                    if (regexText.test(value)) {
                        profession.style.border = '2px solid green';
                    } else {
                        profession.style.border = '2px solid red';
                    }
                }
            } else if (id.startsWith('familySituation' + i)) {
                const familySituation = document.getElementById('familySituation' + i);

                if (value == '') {
                    familySituation.style.border = '2px solid green';
                } else {
                    if (regexText.test(value)) {
                        familySituation.style.border = '2px solid green';
                    } else {
                        familySituation.style.border = '2px solid red';
                    }
                }
            } else if (id.startsWith('cafNumber' + i)) {
                const cafNumber = document.getElementById('cafNumber' + i);

                if (regexCaf.test(value)) {
                    cafNumber.style.border = '2px solid green';
                } else {
                    cafNumber.style.border = '2px solid red';
                }

            }
        }, true)
    }

    // const memberCreate = document.getElementById('memberCreate');
    // const form = document.getElementById('form');

    // memberCreate.addEventListener('click', function (event) {
    //     event.preventDefault();

    //     fetch('controllers/userSpaceController.php', {
    //         method: 'POST',
    //         body: new FormData(form)
    //     }).then(response => {
    //         return response.text();
    //     }).then(text => {
    //         console.log(text);
    //     });

        // const formeData = new FormData();
        // for (let i = 1; i <= responsibleValue; i++) {
        //     const memberLastname = document.getElementById('memberLastname' + i);
        //     const memberFirstname = document.getElementById('memberFirstname' + i);
        //     const memberMail = document.getElementById('memberMail' + i);
        //     const memberPhone = document.getElementById('memberPhone' + i);
        //     const memberBirthdate = document.getElementById('memberBirthdate' + i);
        //     const memberBirthPlace = document.getElementById('memberBirthPlace' + i);
        //     const memberStreetNumber = document.getElementById('memberStreetNumber' + i);
        //     const memberStreetName = document.getElementById('memberStreetName' + i);
        //     const memberStreetComplement = document.getElementById('memberStreetComplement' + i);
        //     const memberZipCode = document.getElementById('memberZipCode' + i);
        //     const memberCity = document.getElementById('memberCity' + i);
        //     const profession = document.getElementById('profession' + i);
        //     const familySituation = document.getElementById('familySituation' + i);
        //     const cafNumber = document.getElementById('cafNumber' + i);

        //     if (
        //         regexText.test(memberLastname.value) &&
        //         regexText.test(memberFirstname.value) &&
        //         regexMail.test(memberMail.value) &&
        //         regexPhone.test(memberPhone.value) &&
        //         birthdate < dateToday &&
        //         regexText.test(memberBirthPlace.value) &&
        //         regexNumber.test(memberStreetNumber.value) &&
        //         regexText.test(memberStreetName.value) &&
        //         regexComplementAddress.test(memberStreetComplement.value) &&
        //         regexZipeCodeAddress.test(memberZipCode.value) &&
        //         regexText.test(memberCity.value) &&
        //         regexText.test(profession.value) &&
        //         regexText.test(familySituation.value) &&
        //         regexCaf.test(cafNumber.value)
        //     ) {
        //         formeData.append('memberLastname' + i, memberLastname.value);
        //         formeData.append('memberFirstname' + i, memberFirstname.value);
        //         formeData.append('memberMail' + i, memberMail.value);
        //         formeData.append('memberPhone' + i, memberPhone.value);
        //         formeData.append('memberBirthdate' + i, memberBirthdate.value);
        //         formeData.append('memberBirthPlace' + i, memberBirthPlace.value);
        //         formeData.append('memberStreetNumber' + i, memberStreetNumber.value);
        //         formeData.append('memberStreetName' + i, memberStreetName.value);
        //         formeData.append('memberStreetComplement' + i, memberStreetComplement.value);
        //         formeData.append('memberZipCode' + i, memberZipCode.value);
        //         formeData.append('memberCity' + i, memberCity.value);
        //         formeData.append('profession' + i, profession.value);
        //         formeData.append('familySituation' + i, familySituation.value);
        //         formeData.append('cafNumber' + i, cafNumber.value);
        //     }
        // }
    // })
})




// divMemberResponsible.addEventListener('change', function (event) {

//     if (event.target.classList.contains('choice')) {
//         let choiceElement = event.target;
//         let choiceValue = event.target.value;
//         console.log(choiceValue);

//         let collectionChoiciCivility = document.getElementsByClassName('choice');
//         let arrayChoiceCivility = [...collectionChoiciCivility];
//         let idCivility = [];
//         let civilityW = 'Madame';
//         let civilityM = 'Monsieur';
//         arrayChoiceCivility.forEach(element => {
//             idCivility.push(element.getAttribute('value'));
//         });

//         if (choiceValue === civilityW || choiceValue === civilityM) {
//             console.log(idCivility);


//             if (idCivility.includes(civilityW) || idCivility.includes(civilityM)) {
//                 console.log('ok');

//                 for (let i = 0; i < arrayChoiceCivility.length; i++) {
//                     arrayChoiceCivility[i].style.border = '.r.iem solid initial';

//                 }

//                 choiceElement.style.border = '.2rem solid green';
//             }
//         }
//     }
// })