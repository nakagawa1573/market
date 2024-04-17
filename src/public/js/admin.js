const all = document.getElementById("all__check");
const modal = document.getElementById("modal");



function allCheck() {
    var checkboxes = document.getElementsByName("id[]");
    all.removeAttribute("onclick");
    all.setAttribute("onclick", "allUnCheck();");
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = true;
    }
}

function allUnCheck() {
    var checkboxes = document.getElementsByName("id[]");
    all.removeAttribute("onclick");
    all.setAttribute("onclick", "allCheck();");
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
}

function openModal() {
    modal.style.display = "block";
}

function closeModal() {
    modal.style.display = "none";
    document.getElementById("subject").value = null;
    document.getElementById("text").value = null;
}

function submitDelete() {
    var form = document.getElementById("form");
    var method = document.createElement('input');
    method.setAttribute("type", "hidden");
    method.setAttribute("name", "_method");
    method.setAttribute("value", "delete");
    form.appendChild(method);
    form.submit();
}
