<?php

session_start();

?>

<?php if($_SESSION['loggedIn']): ?>
    You are logged in. Yay!
    
    <a href="/logged_out.php">Log out</a>
<?php else : ?>
    You are not logged in. Boo!
<?php endif; ?>




