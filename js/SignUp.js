let signUpButton = document.getElementById("signupButton");
let signUpError = document.getElementById("signUpError");

// let currentUser = {}

signupButton.addEventListener('click',()=>{
    let firstName = document.getElementById("typeFName").value;
    let lastName = document.getElementById("typeLName").value;
    let username = document.getElementById("typeUsername").value;
    let password = document.getElementById("typePassword").value;

    let currentUser = {
        "firstname": firstName,
        "lastname": lastName,
        "username": username,
        "password": password
     }

    fetch("API/Registration.php",{
        "method": "POST",
        "headers": {
            "Content-Type" : "application/json; charset=utf-8"
        },

        "body" : JSON.stringify(currentUser)
        })
        // response should be a promise JSON
        .then(function(response){
            return response.text()
        })
        .then((data) =>{
            console.log("here we go")
            if (data == "" || data == null){
                window.location.href = "http://cop4331groupfifteen.xyz/login_page.html";
            }
            else if (data.error != "") {
                signUpError.innerHTML= "Username already exists";
            }
            else {
                window.location.href = "http://cop4331groupfifteen.xyz/login_page.html";
            }
        })
        .catch((error)=>{
            console.log("An error occurred.")
        });
});
// needs a Javascript object
function signUp(info){
    if(info == ""){
        window.location.href = "http://cop4331groupfifteen.xyz/login_page.html";
    }
    else{
        signUpError.innerHTML = "Username Already Exists";
    }
}
