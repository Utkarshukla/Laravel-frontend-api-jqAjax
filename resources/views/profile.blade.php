@include('header')
    <script>
        var token = localStorage.getItem('user_token');
        if (window.location.pathname == '/login' || window.location.pathname == '/register') {
            if (token !=null) {
                window.open('/profile','_self');
            }
        } else {
            if (token ==null) {
                window.open('/login','_self');
            }
        }
    </script>
    

<h4>Profile</h4>
<h5><span class="name"></span></h5>
<div class="email_verify">
    <p><b>Email:-</b><span class="email"></span> &nbsp; <span class="verify"></span></p>
</div>

<form action="" id="profileForm">
    <input type="hidden" name="id" id="user_id">
    <input type="text" name="name" id="name" placeholder="Enter Name"><br>
    <span class="error name_err" style="color: red"></span>
    <br><br>
    <input type="email" name="email" id="email" placeholder="Enter Email"><br>
    <span class="error email_err" style="color: red"></span>
    <br><br>
    <input type="submit" value="Update profile">
</form>
<span class="result"></span>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "http://127.0.0.1:8000/api/profile",
            type: "GET",
            headers: {
                'Authorization': localStorage.getItem('user_token')
            },
            success: function(data) {
                if (data.success == true) {
                    $("#user_id").val(data.data.id);
                    $(".name").text(data.data.name);
                    $(".email").text(data.data.email);
                    //form
                    $("#name").val(data.data.name);
                    $("#email").val(data.data.email);

                    //verifyOrNot
                    if (data.data.is_verified == 0) {
                        $(".verify").html("<button class='verify_mail' data-id='" + data.data
                            .email + "'>Verify</button>");
                    } else {
                        $(".verify").text("Verified");
                    }
                } else {
                    alert(data.msg);
                }
            }
        });

        $("#profileForm").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "http://127.0.0.1:8000/api/profile-update",
                type: "POST",
                data: formData,
                headers: {
                    'Authorization': localStorage.getItem('user_token')
                },
                success: function(data) {
                    if (data.success == true) {
                        $(".error").text("");
                        setTimeout(function() {
                            $(".result").text("");
                        }, 2000);
                        $(".result").text(" User Updated Successfully");
                        $(".name").text(data.data.name);
                        $(".email").text(data.data.email);
                        if (data.data.is_verified == 0) {
                            $(".verify").html("<button class='verify_mail' data-id='" + data.data.email + "'>Verify</button>");
                        } else {
                            $(".verify").text("Verified");
                        }
                        //alert(data.msg);

                    } else {
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
<br>
<script>
    //email verification button api call
    $(document).on('click', '.verify_mail', function() {
        var email = $(this).attr('data-id');
        $.ajax({
            url: "http://127.0.0.1:8000/api/send-verify-mail/" + email,
            type: "GET",
            headers: {
                'Authorization': localStorage.getItem('user_token')
            },
            success: function(data) {
                setTimeout(function() {
                    $(".result").text("");
                }, 2000);
                $(".result").text(data.msg);
            }
        });
    });
</script>

<button class="logout">Logout</button>
<script>
    $(document).ready(function() {

        $(".logout").click(function() {
            $.ajax({
                url: "http://127.0.0.1:8000/api/logout",
                type: "GET",
                headers: {
                    'Authorization': localStorage.getItem('user_token')
                },
                success: function(data) {
                    if (data.success == true) {
                        localStorage.removeItem('user_token');
                        window.open("/login", "_self");
                    } else { //catch error  through here
                        alert(data.msg);
                    }
                }
            });

        });

    });
</script>
</body>

</html>
