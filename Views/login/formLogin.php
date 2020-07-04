<div class="">
    <h1>UBERFOODS</h3>

    <div class="tituloSitio">
    <h2>Autenticación de usuarios</h1>
    </div>

    <div class="form-login">
        <form class="">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="email" type="text" class="form-control" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
            </div>
            <div class="buttoms">
                <input type="button" class="btn btn-lg btn-primary" id="btnEnter" value="Enter" placeholder="Password">
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){

        Cookies.set('user', '');
        Cookies.set('pass', '');
        
        function validateFields(field,mensaje){
            if (field.val() == '') {
                bootbox.alert(mensaje);
                return false;
            }
            return true;
        }

        $('#btnEnter').on('click',function(){

            var email = $('#email');
            var password = $('#password');
            
            if(!validateFields(email,'The email is required')) return;
            if(!validateFields(password,'The password is required')) return;

            $.ajax({
                method: 'GET',
                url: 'https://agrocontrolcr.com/agroTest/user.php/getUsersByCredentials/'+password.val()+'/'+email.val(),
                statusCode: {
                    200: function(msg) {
                    Cookies.set('user', email.val());
                    Cookies.set('pass', password.val());


                    location.href = "Index.php";
                    },
                    404: function(msg){
                        bootbox.alert("The email or password is not valid");
                    }
                }
                });

        });


    });
</script>