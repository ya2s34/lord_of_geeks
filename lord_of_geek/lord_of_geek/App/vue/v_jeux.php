<section id="visite">
    <aside id="categories">
        <ul>
            <?php
            foreach ($lesCategories as $uneCategorie) {
                $idCategorie = $uneCategorie['id'];
                $libCategorie = $uneCategorie['nom'];
            ?>
                <li>
                    <a href=index.php?uc=visite&categorie=<?php echo $idCategorie ?>&action=voirCategories><?php echo $libCategorie ?></a>
                </li>
            <?php
            }

            ?>

        </ul>
        <ul>
            <?php
            foreach ($lesConsoles as $uneConsole) {
                $idConsole = $uneConsole['id'];
                $nomConsole = $uneConsole['nom'];
            ?>
                <li>
                    <a href=index.php?uc=visite&console=<?php echo $idConsole ?>&action=voirConsole><?php echo $nomConsole ?></a>
                </li>
            <?php
            }

            ?>
        </ul>
    </aside>


    <section id="jeux">
        <?php
        $exemplaire_id = 0;
        foreach ($lesJeux as $unJeu) {
            if (isset($unJeu['exemplaires_id'])) {
                $exemplaire_id = $unJeu['exemplaires_id'];
            }
            if (isset($unJeu['exemplaires_nom'])) {
                $exemplaire_nom = $unJeu['exemplaires_nom'];
            }
            $id = $unJeu['id'];
            $nom = $unJeu['nom'];
            $prix = $unJeu['prix'];
            $image = $unJeu['image'];
            $categories_nom = $unJeu['nom'];
            $categories_id = $unJeu['id'];

        ?>

            <article>
                <?php if (in_array($exemplaire_id, $vendu)) : ?>
                    <h1 class="width">Tous les exemplaires de la catégorie sont vendus</h1>
                    <br>

                <?php endif; ?>
                <a href="index.php?uc=visite&id_jeu=<?= $id ?>&action=voirJeux">
                    <img class="img_jeux" src="public/images/jeux/<?= $image ?>" alt="Image de <?= $nom; ?>" />
                </a>

                <?php

                if (in_array($exemplaire_id, $vendu)) : ?>
                    <h1>VENDU </h1>

                <?php endif; ?>

                <p><?= $nom ?></p>


                <?php if (isset($exemplaire_nom)) : ?>
                    <p><?= $exemplaire_nom ?></p>
                <?php endif; ?>
                <?php if ($action != 'voirCatalogue') : ?>
                    <p><?= "Prix : " . $prix . " Euros" ?>
                    <?php endif; ?>
                    <?php
                    $useCase = filter_input(INPUT_GET, 'uc');
                    $action = filter_input(INPUT_GET, 'action');
                    $client = isset($_SESSION['client']) ? $_SESSION['client'] : false;
                
                    ?>

                    <?php if (!$client) : ?>
                        <!-- Code à exécuter si $client est faux -->
                        <?php if (isset($exemplaire_id) && !in_array($exemplaire_id, $vendu) && ($useCase = 'visite' && $action != 'voirCatalogue')) : ?>
                            <a href="index.php?uc=inscription&action=inscriptionClient&action=ajouterAuPanier">
                                <img src="public/images/mettrepanier.png" title="Ajouter au panier" class="add" />
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <!-- Code à exécuter si $client est vrai -->
                        <?php if (isset($exemplaire_id) && !in_array($exemplaire_id, $vendu) && ($useCase = 'visite' && $action != 'voirCatalogue')) : ?>
                            <a href="index.php?uc=visite&categorie=<?= $categories_nom ?>&jeu=<?= $exemplaire_id ?>&action=ajouterAuPanier">
                                <img src="public/images/mettrepanier.png" title="Ajouter au panier" class="add" />
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    </p>
            </article>

        <?php
        }
        ?>
    </section>


</section>