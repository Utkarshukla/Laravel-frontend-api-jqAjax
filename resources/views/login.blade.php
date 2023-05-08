@include('header')
<style>
    span {
        color: red;
    }
</style>
    <h1>Login</h1><br>
    <form action="" id="login-form">
        
        <input type="email" name="email" placeholder="Enter Your Email">
        <br>
        <span class="error email_err"></span>
        <br><br>
        <input type="password" name="password" placeholder="Enter Your password">
        <br>
        <span class="error password_err"></span>
        <br><br>
        <input type="submit" value="Login">
    </form>
    <br>
    <p class="result"></p>
    <script>
        $().ready(function() {
            $("#login-form").submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "http://127.0.0.1:8000/api/login",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        $(".error").text("");
                       if(data.success == false){
                        $(".result").text(data.msg);
                       } else if(data.success == true){
                        localStorage.setItem("user_token",data.token_type+" "+data.access_token);
                        window.open("/profile","_self")
                       } else{
                        printErrorMsg(data);
                       }
                    }
                });
            });

            function printErrorMsg(msg) {
                $(".error").text(""); //clear previous span message
                $.each(msg, function(key, value) {
                    
                        $("." + key + "_err").text(value);
                    

                });
            }
        });
    </script>
</body>

</html>
