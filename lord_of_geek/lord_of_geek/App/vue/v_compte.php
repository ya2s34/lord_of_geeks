<div style="display: flex; justify-content: space-around">
    <div>   
        <h1 style="text-align: center;">Commandes :</h1>

        <section id="compte">
            <article style="display: flex;">
                <?php foreach ($commandesClient as $commandes) {

                    $id = $commandes['id'];
                    $prix = $commandes['prix'];
                    $image = $commandes['image'];
                    $description = $commandes['nom'];
                    $datecommande = $commandes['created_at'];
                ?>
                    <article class="marg">
                        <img src="public/images/jeux/<?= $image ?>" alt="Image de <?= $description; ?>" width="200px" height="200px" />
                        <p><?= $description ?></p>
                        <p><?= "Prix :   $prix  Euros <br> Commandé le : <br>  $datecommande" ?>
                        </p>
                    </article>
                <?php
                }
                ?>
            </article>
        </section>
    </div>
</div>
<div>
    <h1>Information personelle :</h1>
    <form method="POST" action="index.php?uc=compte&action=changerProfil" style="width: 60vw;">
        <fieldset>
            <legend></legend>
            <p>
                Nom : <?= $client['nomPrenom'] ?>
            </p>
            <p>
                Adresse : <?= $client['adresse'] ?>
            </p>
            <p>
                Code Postal : <?= $client['c_postal'] ?>
            </p>
            <p>
                Ville : <?= $client['ville'] ?>
            </p>
            <p>
                Mail : <?= $client['email'] ?>
            </p>
            <p>
                Téléphone : <?= $client['tel'] ?>
            </p>
    </form>
</div>

</div>