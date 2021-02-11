<?php

class SiteUnderMaintenanceExeption extends Exception
{
    protected $message = "Notre site est en maintenance, merci pour votre compréhension";
    protected  $file ="";
}

class invalidDatabaseConnection extends Exception
{
    protected $message = "Une erreur c'est produit durant la connexion avec la base de donnée, veuillez réessayer ulterieurement";
    protected  $file ="";
}
