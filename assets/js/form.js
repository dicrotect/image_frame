document.getElementById("contact-form").onsubmit = function() {
    var nameValidate = /[a-z]/;
    //Validate Name
    if(document.getElementById("form-name-field").value == "") {
        document.getElementById("nameError").innerHTML = "Please Enter A Name";
        document.getElementById("nameError").className = "alert-danger";
    }
}
