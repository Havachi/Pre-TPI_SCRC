<?php

class illegalCharDetected extends Exception
{
    protected $message = "Nous avons détecter un caratère illégal dans votre saisie, si cela est une erreur, veuillez contacter l'administrateur";
}
class invalidInputException extends Exception
{
    protected $message = "Saisie invalide, veuillez vérifer votre saisie";
}
