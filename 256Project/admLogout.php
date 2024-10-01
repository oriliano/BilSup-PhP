<?php
   session_start() ;
   require "db.php" ;

  

   if ( !isAuthenticatedAdmin()) {
      header("Location: main.php") ;
      exit ;
   }

  

   // delete remember me part
   setTokenByEmailAdmin($_SESSION["admin"]["email"], null) ;
   setcookie("access_token", "", 1) ; 
   
   // delete session file
   session_destroy() ;
   // delete session cookie
   setcookie("PHPSESSID", "", 1 , "/") ; // delete memory cookie 

   // redirect to login page.
   header("Location: main.php") ;