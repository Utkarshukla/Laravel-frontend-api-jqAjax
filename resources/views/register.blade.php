@include('header')
<style>
    span {
        color: red;
    }
</style>
<h1>New Registeration</h1><br>
<form action="" id="register-form">
    <input type="text" name="name" placeholder="Enter Your Name">
    <br>
    <span class="error name_err"></span>
    <br><br>
    <input type="email" name="email" placeholder="Enter Your Email">
    <br>
    <span class="error email_err"></span>
    <br><br>
    <input type="password" name="password" placeholder="Enter Your password">
    <br>
    <span class="error password_err"></span>
    <br><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Your Password">
    <br>
    <span class="error password_confirmation_err"></span>
    <br><br>

    <input type="submit" value="Register">

</form>
<br>
<p class="result"></p>
<script>
    $().ready(function() {
        $("#register-form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "http://127.0.0.1:8000/api/register",
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.msg) {
                        $("#register-form")[0].reset();
                        $(".error").text("")
                        $(".result").text(data.msg);
                    } else {
                        $(".result").text("");
                        printErrorMsg(data);
                    }
                }
            });
        });

        function printErrorMsg(msg) {
            $(".error").text(""); //clear previous span message
            $.each(msg, function(key, value) {
                if (key == 'password') {
                    if (value.length > 1) {
                        $(".password_err").text(value[0]);
                        $(".password_confirmation_err").text(value[1]);
                    } else {
                        if (value[0].includes('password field confirmation')) {
                            $(".password_confirmation_err").text(value);
                        } else {
                            $(".password_err").text(value);
                        }
                    }

                } else {
                    $("." + key + "_err").text(value);
                }

            });
        }
    });
</script>
</body>

</html>
