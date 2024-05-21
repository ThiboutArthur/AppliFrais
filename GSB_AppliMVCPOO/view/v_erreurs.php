<?php
/**
 * Vue Erreurs
 *
 * PHP Version 8
 *
 * @category  AP
 * @package   GSB
 * @link      Contexte « Laboratoire GSB »
 */
?>
<div class="alert alert-danger" role="alert">
    <?php
    foreach ($_REQUEST['erreurs'] as $erreur) {
        echo '<p>' . htmlspecialchars($erreur) . '</p>';
    }
    ?>
</div>
<?php
if($retour == "/")
{
    $chaine = "Refresh: 3;URL=".HOST."connexion";
    header($chaine);
}
elseif($retour == 'accueil')
{
    $chaine = "Refresh: 3;URL=".HOST."accueil";
    header($chaine);
}

