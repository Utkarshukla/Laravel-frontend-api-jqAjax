@include('header')
<h1>Forget Password</h1>
<form id="forgetForm">
    <input type="email" name="email" placeholder="Enter Registered Mail">
    <input type="submit" value="ForgetPassword">
</form>
<div class="result"></div>
<script>
    $(document).ready(function() {
        $("#forgetForm").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "http://127.0.0.1:8000/api/forget-password",
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.success == true) {
                        $(".result").text(data.msg);
                    } else {
                        $(".result").text(data.msg);
                        setTimeout(function() {
                            $(".result").text("");
                        }, 2000);
                    }
                }
            });
        });
    });
</script>
