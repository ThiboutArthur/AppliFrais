<?php
/**
 * Vue Déconnexion
 *
 * PHP Version 8
 *
 * @category  AP
 * @package   GSB
 * @link      Contexte « Laboratoire GSB »
 */

deconnecter();
?>
<div class="alert alert-info" role="alert">
    <p>Vous avez bien été déconnecté ! <a href="<?= HOST; ?>connexion">Cliquez ici</a>
        pour revenir à la page de connexion.</p>
</div>
<?php
$chaine = "Refresh: 3;URL=".HOST."connexion";
header($chaine);
