// Fonction à exécuter lorsqu'on clique sur l'image
function maFonction(subjectID, id) {
    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        url: "./action/getComments.php",
        type: "POST",
        data: { id : id}, // Passer les IDs comme données de la requête
        success: function(data) {
            
        },
        error: function(xhr, status, error) {
            // Gérer les erreurs ici
            console.error("Erreur lors de la requête AJAX :", status, error);
        }
    });
}

// Utilisation de jQuery pour détecter le clic sur l'image
$("#comment").click(function() {
    var id = $(".post").attr("id");
    console.log("id post " + id);
    // Récupérer l'ID du sujet dans le quel est stocker dans comment
    var subjectID = $(".post").closest(".subject").attr("id");
    console.log("id subject " + subjectID);
    //Appelle de la fonction pour chaque post qui sont présent dans subject ayant l'id subjectID
    $(".post").each(function() {
        maFonction(subjectID, $(this).attr("id"));
    });
});
