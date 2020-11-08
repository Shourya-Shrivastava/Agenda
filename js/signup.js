$(document).ready(function() {

    $('#signup').on('click', function() {

        var firstname = $('#FirstName').val();
        var lastname = $('#LastName').val();
        var email = $('#InputEmail').val();
        var pass1 = $('#InputPassword').val();
        var pass2 = $('#ConfirmInputPassword').val();

        $.ajax({
            url: 'signup.php',
            type: 'post', 
            data: {
                firstname: firstname,
                lastname: lastname, 
                email: email,
                pass1: pass1,
                pass2: pass2
            },
            success: function(){
                console.log("signed up");
            }
        })

    });

});