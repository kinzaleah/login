<?php


$twig = getTwig();




if (!empty($_SESSION['user'])) 
{
    header('Location: /logged_in.php');
    
}


//run the functions if someone posts - validateInput first then if all ok registerUSer

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    
    $usernameIsValid = usernameIsValid($_POST['username']);
    $emailIsValid = emailIsValid($_POST['email']);
    $passwordIsValid = passwordIsValid($_POST['password']);
    
    if($usernameIsValid === true && $emailIsValid === true && $passwordIsValid === true) 
    {
        
        //hash the password & pass the new var into registerUser
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        //convert username to lowercase before adding to db
        $lowerUsername = strtolower($_POST['username']);
        
        $usernameExistsError = "";
        
        //IF username doesn't already exist then it can all be written to db
        if(!usernameExists($lowerUsername)) 
        {
            registerUser($lowerUsername, $passwordHash, $_POST['email']);
            //I want to redirect to the success page here so the user knows they've registered
            header('Location: /register_success');
        } else {
            $usernameExistsError = "Username already exists, please choose another!";
        }
    }
}


$errorMessages = [];

if ($usernameIsValid !== true) 
{
    $errorMessages['username'] = $usernameIsValid;
   
}

if (!empty($usernameExistsError)) 
{
    $errorMessages['username'] = $usernameExistsError;
}

if ($emailIsValid !== true) 
{
    $errorMessages['email'] = $emailIsValid;
}

if ($passwordIsValid !== true) 
{
    $errorMessages['password'] = $passwordIsValid;
}


echo $twig->render('register.twig', ['errorMessages' => $errorMessages, 'loggedIn' => !empty($_SESSION['user'])]);

?>