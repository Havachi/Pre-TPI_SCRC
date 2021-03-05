<?php

class illegalCharDetected extends Exception
{
    protected $message = "Nous avons détecter un caratère illégal dans votre saisie, si cela est une erreur, veuillez contacter l'administrateur";
}
class invalidInputException extends Exception
{
    protected $message = "Saisie invalide, veuillez vérifer votre saisie";
}
class alreadyInUseEmail extends Exception
{
    protected $message = "Cette adresse email est deja en cours d'utilisation";
}
class loginError extends Exception
{
  protected $message = "Adresse E-mail ou mot de passe incorrecte, veuillez réessayer";
}
