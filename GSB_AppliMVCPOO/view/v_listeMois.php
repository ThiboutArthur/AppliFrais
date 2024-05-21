<?php
/**
 * Vue Liste des mois
 *
 * PHP Version 8
 *
 * @category  AP
 * @package   GSB
 * @link      Contexte « Laboratoire GSB »
 */
?>
<h2>Mes fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois : </h3>
    </div>
    <div class="col-md-4">
        <form action="<?= HOST; ?>etatFrais/action/voirEtatFrais"
              method="post" role="form">
            <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                        foreach ($lesMois as $unMois) 
                        {
                            $mois = $unMois['mois'];
                            $numA = $unMois['numAnnee'];
                            $numM = $unMois['numMois'];
                            
                            if ($mois == $leMois) {
                                ?>
                                <option selected value="<?php echo $mois ?>">
                                    <?php echo $numM . '/' . $numA ?> </option>
                                <?php
                            } else 
                            {
                                if(isset($numMois) && isset($numAnnee) && $numM == $numMois && $numA == $numAnnee)
                                {
                                    ?>
                                    <option selected value="<?php echo $mois ?>">
                                        <?php echo $numMois . '/' . $numAnnee ?> </option>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <option value="<?php echo $mois ?>">
                                        <?php echo $numM . '/' . $numA ?> </option>
                                    <?php
                                }
                            }
                        }
                    
                    ?>
                </select>
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success"
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger"
                   role="button">
        </form>
    </div>
</div>
