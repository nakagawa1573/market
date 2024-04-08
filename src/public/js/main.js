var comment = document.getElementById("switch");
var modal = document.getElementById("modal");
var main = document.getElementById("main");

function openModal() {
    modal.style.display = "block";
    main.style.display = "none";
    comment.removeAttribute("onclick");
    comment.setAttribute("onclick", "closeModal();");
}

function closeModal() {
    modal.style.display = "none";
    main.style.display = "block";
    comment.removeAttribute("onclick");
    comment.setAttribute("onclick", "openModal();");
}

function switchTab() {
    var modal = document.getElementById("modal");
    var main = document.getElementById("main");
    var select = document.getElementById("select");
    var none = document.getElementById("none");

    modal.id = "main";
    main.id = "modal";

    select.id = "none";
    select.removeAttribute("onclick");
    select.setAttribute("onclick", "switchTab();");

    none.id = "select";
    none.onclick = "";
    none.removeAttribute("onclick");
    none.setAttribute("onclick", "");
}
