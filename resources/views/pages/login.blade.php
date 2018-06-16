<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BitEx | Login</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </head>
    <body>
        <p>&nbsp;</p>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <?php if( isset($ERROR_MESSAGE) ): ?>
                    <div class="alert alert-danger">
                        <strong><?php echo $ERROR_MESSAGE; ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="account-wall">
            <form class="form-signin" action="/login" method="POST">
                {{ csrf_field() }}
                <input type="text" name="email" class="form-control" placeholder="email" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="password" required>
                <button class="btn btn-primary btn-block" name="login" type="submit">Sign in</button>
            </form>
            <p><a href="register.php">Don't you have an account?</a></p>
            <p><a href="forgot.php">Forgot your password?</a></p>
        </div>
    </div>
    </body>
</html>
