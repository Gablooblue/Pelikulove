@include('scripts.tooltips')

@if(config('settings.reCaptchStatus'))
<script src='https://www.google.com/recaptcha/api.js'></script>
@endif

<script>
    $(document).ready(function() {
        // Passwords
        $("#form-show-password a").on('click', function(event) {
            event.preventDefault();
            if ($('#form-show-password input').attr("type") == "text") {
                $('#form-show-password input').attr('type', 'password');
                $('#form-show-password i').addClass("fa-eye-slash");
                $('#form-show-password i').removeClass("fa-eye");
            } else if ($('#form-show-password input').attr("type") == "password") {
                $('#form-show-password input').attr('type', 'text');
                $('#form-show-password i').removeClass("fa-eye-slash");
                $('#form-show-password i').addClass("fa-eye");
            }
        });

        // Sign Up btn Enable on Scroll Down
        // document.getElementsByName("container_terms")[0].addEventListener("scroll", checkScrollHeight, false);

        // var tosDiv = document.getElementsByName("container_terms")[0];
        // var signUpBtn = document.getElementById("signUp");

        // function checkScrollHeight() {                

        //     if(tosDiv.scrollTop >= (tosDiv.scrollHeight - tosDiv.offsetHeight)) {
        //         signUpBtn.disabled = false;
        //         // Remove tooltip on sign up enable
        //         signUpBtn.title = '';
        //     }
        // }  

        $("#logInSwitch").on('click', function(event) {
            event.preventDefault();
            $('.signup-mode').css('display', 'none');
            $('.login-mode').css('display', 'block');
        });   

        $("#signUpSwitch").on('click', function(event) {
            event.preventDefault();
            $('.login-mode').css('display', 'none');
            $('.signup-mode').css('display', 'block');
        });   
    })
</script>