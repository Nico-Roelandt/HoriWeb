// Fonction à exécuter lorsqu'on clique sur l'image
function maFonction(subjectID, id) {
    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        url: "./action/getComments.php",
        type: "POST",
        data: { id : id}, // Passer les IDs comme données de la requête
        success: function(data) {
            console.log(data);

        },
        error: function(xhr, status, error) {
            // Gérer les erreurs ici
            console.error("Erreur lors de la requête AJAX :", status, error);
        }
    });
}

var clicked = false;

$(".postIcon").click(function() {
    if (!clicked) {
        clicked = true;

        // Trouver le .post parent et récupére l'id de son parent
        var id_subject = $(this).closest('.subject').attr('id');

        

        // Trouver tous les autres .post avec le même id_subject
        var otherPosts = $('.post').filter(function() {
            return $(this).closest('.subject').attr('id') === id_subject;
        });


        // Appeler maFunction sur les autres posts
        otherPosts.each(function() {
            console.log($(this).attr('id'));
            maFonction(id_subject, $(this).attr('id'));
        });
    }
});

