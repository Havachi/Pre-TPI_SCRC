<?php

$GLOBALS['DEBUG_DB'] = true;

$files = glob($_SERVER['DOCUMENT_ROOT'] . "/content/images/" . "*");
if ($files){
 $filecount = count($files);
 $GLOBALS['FILES'] = $files;
 $GLOBALS['COUNT_IMAGE'] = $filecount;
}

$GLOBALS['UPLOAD_ERROR_MESSAGE'] = array(
    0 => 'Aucune erreur, le fichier à été téléchargé avec succès ! ',
    1 => 'Le fichier est trop grand, il dépasse la taille maximal du serveur',
    2 => 'Le fichier est trop grand, il dépasse la taille maximal de la page',
    3 => 'Le fichier n\'a pas totalement été téléchargé',
    4 => 'Aucun fichier reçu',
    6 => 'Le dossier temporaire n\'existe pas',
    7 => 'Impossible d\'écrire sur le disque',
    8 => 'Une extention PHP à interrompu le téléchargement',
);
