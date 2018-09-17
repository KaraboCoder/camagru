var loginUser = function(){
    var form = document.getElementById("loginForm");
    var email = form.email.value;
    var password = form.password.value;
    var data = "action=login&" + "email=" + email + "&password=" + password;

    sendToServer(data, "functions/login.php");
};

var signupUser = function(){
    var form = document.getElementById("signupForm");
    var email = form.email.value;
    var password = form.password.value;
    var username = form.username.value;
    var verify_password = form.verify_password.value;
    var data = "action=signup&" + "email=" + email + "&password=" + password + "&username=" + username;

    /**************************************
     *      VALIDATE AND SIGNUP           *
     **************************************/

    if (email.length == 0 || password.length == 0 || username.length == 0 || verify_password.length == 0)
        document.getElementById("error-container").innerHTML = "<p class='error'>Error. All inputs are required.</p>";
    else
    {
        if (verify_password == password)
            sendToServer(data, "functions/signup.php");
        else
            document.getElementById("error-container").innerHTML = "<p class='error'>Passwords do not match.</p>";
    }
};

var sendResetPasswordLink = function(){
    var form = document.getElementById("fogortPasswordForm");
    var email = form.email.value;
    var data = "action=reset_link&email=" + email;

    /*****************************************
    *       SEND RESET PASSWORD LINK
    * ***************************************/

    sendToServer(data, "functions/send_reset_password_link.php");
}

var login_container = document.getElementById("loginForm-container");
var signup_container = document.getElementById("signupForm-container");
var forgot_password_container = document.getElementById("forgotPassword-container");

var login_link = document.getElementById("login-link");
login_link.addEventListener("click",function (e) {
    signup_container.classList.add("hide");
    login_container.classList.remove("hide");
});

var signup_link = document.getElementById("signup-link");
signup_link.addEventListener("click",function (e) {
    login_container.classList.add("hide");
    signup_container.classList.remove("hide");
    document.getElementById("error-container").innerHTML = "";
});

var forgot_password_link = document.getElementById("forgot-password-link");
forgot_password_link.addEventListener("click",function (e) {
    login_container.classList.add("hide");
    signup_container.classList.add("hide");
    forgot_password_container.classList.remove("hide");
    document.getElementById("error-container").innerHTML = "";
});

var back_link = document.getElementById("back-link");
back_link.addEventListener("click",function (e) {
    login_container.classList.remove("hide");
    signup_container.classList.add("hide");
    forgot_password_container.classList.add("hide");
    document.getElementById("error-container").innerHTML = "";
});
