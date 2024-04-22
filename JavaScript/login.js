$(document).ready(function() {
    //affiche
    $('#popup').modal('show');
    // Gérer le clic sur le bouton "Se connecter"
    $('#popup-button').on('click', function() {
        console.log('click');
        $('.popup').modal('show');
    });
});
