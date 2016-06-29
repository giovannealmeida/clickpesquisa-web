console.log("Script carregado");
function inicializaCheckBox() {
    var quebraLinha = document.createElement("br");

    var lblAlternativas = document.createElement("label");
    lblAlternativas.innerHTML = "Alternativas";

    var checkBoxItem = document.createElement("input");
    checkBoxItem.type = "checkbox";
    checkBoxItem.name = "example";

    var inputAlternativa = document.createElement("input");
    inputAlternativa.type = "text";
    inputAlternativa.name = "alternativas[]";
    
    var buttonRemove = document.createElement("button");
    buttonRemove.innerHTML = "Remover";
    buttonRemove.id = "checkRemoveButton";
    buttonRemove.type = "button";
    
    
    var buttonAdd = document.createElement("button");
    buttonAdd.innerHTML = "Nova Alternativa";
    buttonAdd.id = "checkAddButton";
    buttonAdd.type = "button";
    



    $("#question_item_container").append(lblAlternativas);
    $("#question_item_container").append(quebraLinha);
    $("#question_item_container").append(checkBoxItem);
    $("#question_item_container").append(inputAlternativa);
    $("#question_item_container").append(buttonAdd);
}

function novoItemChecklist() {
    var quebraLinha = document.createElement("br");

    var checkBoxItem = document.createElement("input");
    checkBoxItem.type = "checkbox";
    checkBoxItem.name = "example";

    var inputAlternativa = document.createElement("input");
    inputAlternativa.type = "text";
    inputAlternativa.name = "alternativas[]";
    
    $("#checkAddButton").before(quebraLinha);
    $("#checkAddButton").before(checkBoxItem);
    $("#checkAddButton").before(inputAlternativa);
}

$(document.body).on('click', '#checkAddButton', function(){
    novoItemChecklist();
});

$("#question_type").change(function () {
    var idType = parseInt(this.value);
    if (isNaN(idType)) {
        idType = 0;
    }
    switch (idType) {
        case 0:
            $("#question_item_container").empty();
            break;
        case 1:
            $("#question_item_container").empty();
            break;
        case 2:
            inicializaCheckBox();
            break;
    }
});