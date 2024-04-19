



<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <?php if($_SESSION['errorNewPost'] == "true"){ ?>
    <div id="toatNotif" class="toast bg-danger btn-close-white border-0 text-light" role="alert" aria-live="assertive" aria-atomic="true">
        <?php } else { ?>
    <div id="toatNotif" class="toast bg-success btn-close-white border-0 text-light" role="alert" aria-live="assertive" aria-atomic="true">
        <?php } ?>
        <div class="toast-body">
            <?php 
            if($_SESSION['errorNewPost'] == "true"){
                echo "Problème lors de la publication, merci de réessayer.";
            } else {
                echo "Publication réussie.";
            }
            ?>
        </div>
    </div>
</div>


<script>
      function alertPost(error) {
        const toastBootstrap = new bootstrap.Toast(document.getElementById("toatNotif"))
        toastBootstrap.show()
      }
</script>

<?php
 if(isset($_SESSION['errorNewPost'])){
  echo '<script type="text/javascript" defer>alertPost();</script>';
  unset($_SESSION['errorNewPost']);
 }
 ?>

</body>
</html>
