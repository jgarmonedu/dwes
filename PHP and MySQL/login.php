<?php // Do not put any HTML above this line

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

$failure = false;  // If we have no POST data

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['who']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "User name and password are required";
    } elseif (!str_contains($_POST['who'],"@")) {
        $failure = "Email must have an at-sign (@)";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            error_log("Login success ".$_POST['who']);
            // Redirect the browser to autos.php
            header("Location: autos.php?name=".urlencode($_POST['who']));
            return;
        } else {
            $failure = "Incorrect password";
            error_log("Login fail ".$_POST['who']." $check");
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <title>Javier Garcia's Login Page 8735d8e3</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    // Note triple not equals and think how badly double
    // not equals would work here...
    if ($failure) {
        // Look closely at the use of single and double quotes
        echo('<p style="color: red;">'.$failure."</p>\n");
    }
    ?>
    <form method="POST">
        <label for="nam">User Name</label>
        <input type="text" name="who" id="nam"><br/>
        <label for="id_1723">Password</label>
        <input type="password" name="pass" id="id_1723"><br/>
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
        <!-- Hint: The password is the three character name of the
        programming language used in this class (all lower case)
        followed by 123. -->
    </p>
</div>
</body>