var formAction = 0;

function form(event){
    event.preventDefault();
    var question = document.querySelector("#form_thingy input[type='text']").value;
    var reponse = document.querySelector("#response");
    var randomQuestion = new Array(
        "Чет жарко, не ?",
        "Я не люблю болтунов, а ты ?",
        "Есть кофе ?"
    );
    switch(formAction) {
        case 0:
            if (question.indexOf("нет") > -1) {
                reponse.innerHTML = "Какой у тебя логин ?";
                formAction = 10;
            } else if (question.indexOf("да") > -1) {
                reponse.innerHTML = "Круто ?";
                formAction = 20;
            } else {
                reponse.innerHTML = "Я не понял :/";
            }
            break;
        case 10:
            reponse.innerHTML = "Здарова " + question + " ! Пилишь писин PHP ?";
            formAction = 11;
            break;
        case 11:
            if (question.indexOf("нет") > -1) {
                reponse.innerHTML = "шо ?";
                formAction = 12;
            } else if (question.indexOf("да") > -1) {
                reponse.innerHTML = "Огонь. Сколько задач уже сделал ?";
                formAction = 13;
            } else {
                reponse.innerHTML = "Я не понял :/";
            }
            break;
        case 12:
                reponse.innerHTML = "Нормас :)";
                formAction = 100;
            break;
        case 13:
            if (question.indexOf("1") > -1)
                reponse.innerHTML = "Если че, помогу !";
            if (question.indexOf("2") > -1)
                reponse.innerHTML = "Молодец.";
            if (question.indexOf("3") > -1)
                reponse.innerHTML = "Кек";
            if (question.indexOf("4") > -1)
                reponse.innerHTML = "Простая менюшка в CSS :)";
            if (question.indexOf("5") > -1)
                reponse.innerHTML = "=)";
            formAction = 100;
            break;
        case 20:
            if (question.indexOf("нет") > -1) {
                reponse.innerHTML = "О, почему это круто ?";
                formAction = 21;
            } else if (question.indexOf("да") > -1) {
                reponse.innerHTML = "Удачи :D Что делаешь сейчас ?";
                formAction = 22;
            } else {
                reponse.innerHTML = "Ниче не понял :/";
            }
            break;
        case 21:
            reponse.innerHTML = "Ты не прав";
            formAction = 100;
            break;
        case 22:
            reponse.innerHTML = "Удачи :)";
            formAction = 100;
            break;
        case 100:
            reponse.innerHTML = randomQuestion[Math.floor((Math.random() * randomQuestion.length))];
            formAction = 100;
            break;
    }
    document.querySelector("#form_thingy input[type='text']").value = " ";
}

window.onload = function () {
    document.querySelector("#form_thingy").addEventListener("submit", form);
}