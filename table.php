<?php
    require_once 'Model/dbConfig.php';
    if(isset($_GET['page']) && !empty($_GET['page'])) {
        $currentPage = (int) strip_tags($_GET['page']);
    } else {
        $currentPage = 1;
    }
?>

<!-- Favicons -->
<link href="/assets/img/logo.png" rel="icon">
<link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<section class="sample-page">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="p-3 row">
                <div class="col-md-15">
                    <div class="mb-3 clearfix table-head">
                        <div class="table-head2 d-flex justify-content-between align-items-center">
                            <div>
                                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                                    <select name="row_per_page" class="emp_det1">
                                        <option value="3">3</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <button style="width: 70px" type="submit" class="btn bg-primary text-light">Search</button>
                                </form>
                            </div>
                            <div><a href="#" class="btn bg-success pull-right" style="color:#eeeee4; margin-left: 40px"><i class="fa fa-plus"></i> Add Row</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   

    <?php
    // Query
    $number = "SELECT * FROM fournisseur NATURAL JOIN entite NATURAL JOIN chefdeprojet NATURAL JOIN commande NATURAL JOIN facture";

    // Preparing query
    $query = $conn->prepare($number);

    // Query execution
    $query->execute();

    // Number of rows
    $result = $query->get_result();

    $nbRows= $result->num_rows;

    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;

    // rows per page
    $perPage = isset($_POST["row_per_page"]) ? $_POST["row_per_page"] : $limit;

    // Total pages number
    $pages = ceil($nbRows / $perPage);

    // 
    $premier = ($currentPage * $perPage) - $perPage;

    // Attempt select query execution
    $sql = "SELECT * FROM fournisseur NATURAL JOIN entite NATURAL JOIN chefdeprojet NATURAL JOIN commande NATURAL JOIN facture LIMIT ?, ?";
    // $result->num_rows;

    if ($statement = $conn->prepare($sql)){
        $statement->bind_param('ii',  $premier, $perPage);
        if($statement->execute()){
            $result = $statement->get_result();
            if($result->num_rows > 0){
                echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>numCommande</th>";
                            echo "<th>codeFournisseur</th>";
                            echo "<th>nomFournisseur</th>";
                            echo "<th>siteFournisseur</th>";
                            echo "<th>nomEntite</th>";
                            echo "<th>nomCDP</th>";
                            echo "<th>service</th>";
                            echo "<th>typeDAchatPO</th>";
                            echo "<th>uniteOperationelle</th>";
                            echo "<th>montantCommande</th>";
                            echo "<th>montantReceptionne</th>";
                            echo "<th>acheteur</th>";
                            echo "<th>identifiantGED</th>";
                            echo "<th>numeroFacture</th>";
                            echo "<th>montantDesFactures</th>";
                            echo "<th>montantFactureTTCDevise</th>";
                            echo "<th>montantMiseADisposition</th>";
                            echo "<th>intervenant</th>";
                            echo "<th>nombreDeJoursAEcheance</th>";
                            echo "<th>cA</th>";
                            echo "<th>blocage</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_array()){
                        echo "<tr>";
                            echo "<td>" . $row['numCommande'] . "</td>";
                            echo "<td>" . $row['codeFournisseur'] . "</td>";
                            echo "<td>" . $row['nomFournisseur'] . "</td>";
                            echo "<td>" . $row['siteFournisseur'] . "</td>";
                            echo "<td>" . $row['nomEntite'] . "</td>";
                            echo "<td>" . $row['nomCDP'] . "</td>";
                            echo "<td>" . $row['service'] . "</td>";
                            echo "<td>" . $row['typeDAchatPO'] . "</td>";
                            echo "<td>" . $row['uniteOperationelle'] . "</td>";
                            echo "<td>" . $row['montantCommande'] . "</td>";
                            echo "<td>" . $row['montantReceptionne'] . "</td>";
                            echo "<td>" . $row['acheteur'] . "</td>";
                            echo "<td>" . $row['identifiantGED'] . "</td>";
                            echo "<td>" . $row['numeroFacture'] . "</td>";
                            echo "<td>" . $row['montantDesFactures'] . "</td>";
                            echo "<td>" . $row['montantFactureTTCDevise'] . "</td>";
                            echo "<td>" . $row['montantMiseADisposition'] . "</td>";
                            echo "<td>" . $row['intervenant'] . "</td>";
                            echo "<td>" . $row['nombreDeJoursAEcheance'] . "</td>";
                            echo "<td>" . $row['cA'] . "</td>";
                            echo "<td>" . $row['blocage'] . "</td>";
                            echo "<td>";
                                echo '<a href="ingredient-details.php?page='.$currentPage.'&identifiantGED='. $row['identifiantGED'] .'" class="mr-3" title="View facture Details" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a class="m-3" href="ingredient-update.php?page='.$currentPage.'&identifiantGED='. $row['identifiantGED'] .'" class="mr-3" title="Update row" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="" data-toggle="modal" data-target="#exampleModal" title="Delete row"><span class="fa fa-trash"></span></a>';
                                ?>

                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";
                // Free result set
                $result->free();
            } else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }

        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close connection
    $conn->close();
    ?>

    <nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="table.php?page=<?= $currentPage - 1 ?>&limit=<?= $perPage ?>" class="page-link">Previous</a>
        </li>
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="" class="page-link">Page : <?php echo $currentPage ?></a>
        </li>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
            <a href="table.php?page=<?= $currentPage + 1 ?>&limit=<?= $perPage ?>" class="page-link">Next</a>
        </li>
    </ul>
    </nav>
</section> 