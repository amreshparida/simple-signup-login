document.addEventListener("DOMContentLoaded", () => {
    if(document.getElementById('registerForm')){
        const form = document.getElementById('registerForm');
        form.addEventListener('submit',function(e) {
            e.preventDefault();
            validateregisterForm();
        });
    }
});
var err_msg = [];
function validateregisterForm(){
    err_msg = [];
        //Fullname validation
        if( document.registerForm.fullname.value.trim() == "" ) {
            err_msg.push( "Please provide your name!" );
            document.registerForm.fullname.focus() ;
         }
         //Email validation
         if( document.registerForm.email.value.trim() == "" || !document.registerForm.email.value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
            err_msg.push( "Please provide valid email!" );
            document.registerForm.email.focus() ;
         }
         //Password validation
         if( document.registerForm.password.value.trim() == "" || document.registerForm.password.value.trim().length<8 || !document.registerForm.password.value.match(/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/) ) {
            err_msg.push( "Please provide a strong password - min 8 letter, with at least a symbol, upper and lower case letters and a number!" );
            document.registerForm.password.focus() ;
         }
         //Retype Password validation
         if( document.registerForm.password.value != document.registerForm.password_again.value ) {
            err_msg.push( "Password doesnot matched!" );
            document.registerForm.password_again.focus() ;
         }

        if(err_msg.length>0){
            console.log(err_msg)
            document.getElementsByClassName("err-message")[0].innerHTML = "";
            err_msg.forEach(printErrors);
        }else{
            document.registerForm.submit();
        }
}

function printErrors(item, index) {
    document.getElementsByClassName("err-message")[0].innerHTML += item + "<br>"; 
}