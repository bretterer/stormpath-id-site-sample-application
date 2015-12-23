<html>
<head>
    <title>Lumen</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
            margin-bottom: 40px;
        }

        .quote {
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if( Session::has('notice') ): ?>
        <p><?php echo Session::get('notice'); ?></p>
    <?php endif; ?>
    <nav>
        <?php if( Session::has('user') ): ?>
            Welcome, <?php echo Session::get('user')->givenName; ?> |
            <a href="/logout">Logout</a>
        <?php else : ?>
            <a href="/login">Login</a> |
            <a href="/register">Register</a> |
            <a href="/forgotPassword">Forgot Password</a>
        <?php endif; ?>


    </nav>
    <div class="content">
        <div class="title">Lumen.</div>
    </div>
</div>
</body>
</html>