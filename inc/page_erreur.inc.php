<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Tutoriels</title>

    <!-- include jQuery -->
    <script src="<?php echo __WEBROOT__ ?>/lib/jquery/3.4.1/jquery.min.js"></script>

    <!-- include bootstrap css/js -->
    <link href="<?php echo __WEBROOT__ ?>/lib/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo __WEBROOT__ ?>/lib/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="container-sm">
      <div class="jumbotron mt-4">
        <h1 class="display-4 text-danger">Une erreur s'est produite</h1>
        <hr class="my-4">
        <p class="lead">Code : <?php echo $e->getCode(); ?></p>
        <p class="lead">Message :</p>
        <p class="lead ml-4"><?php echo $e->getMessage(); ?></p>
        <p class="text-right">
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseInfosSup" aria-expanded="false" aria-controls="collapseInfosSup">
            Informations complémentaires
          </button>
        </p>
        <div class="collapse" id="collapseInfosSup">
          <div class="card card-body">
            <p class="mb-0">Fichier : <?php echo $e->getFile(); ?></p>
            <p class="mb-0">Ligne : <?php echo $e->getLine(); ?></p>
            <?php
              $traces = $e->getTrace();
              for ($i = 0; $i < count($traces); $i++) {
                echo '<div class="mt-2">Trace '.($i + 1).' :';
                echo '<p class="ml-4 mb-0">Fichier : '.$traces[$i]['file'].'</p>';
                echo '<p class="ml-4 mb-0">Ligne : '.$traces[$i]['line'].'</p>';
                echo '<p class="ml-4 mb-0">Fonction : '.$traces[$i]['function'].'</p>';
                if (count($traces[$i]['args']) > 0) {
                  echo '<div class="ml-4 mb-0">Arguments :';
                  for ($j = 0; $j < count($traces[$i]['args']); $j++) {
                    echo '<p class="ml-4 mb-0">Argument '.($j + 1).' : '.$traces[$i]['args'][$j].'</p>';
                  }
                }
                echo '</div>';
              }
            ?>
            
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
