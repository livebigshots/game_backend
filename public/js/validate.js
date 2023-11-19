$(document).ready(function() {
    $("#changePasswordForm").validate({

        rules: {
            old_password: {
                required:true,
            },
            password: {
                required:true,
            },
            confirm_password: {
                required:true,
            }
        },
        messages:{
            old_password: {
                required:"Old password is required",
            },
            password: {
                required:"Password is required",
            },
            confirm_password: {
                required:"Confirm password is required",
            }
        }
    });

});
