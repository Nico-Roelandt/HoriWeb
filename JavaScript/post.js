var click = false;
$('img.postIcon[data-bs-target="#comment"]').click(function() {
    if(click){
      return;
    }
    click = true;
    var btnId = $(this).attr('id');
    console.log('ID du bouton : ' + btnId);
    $.ajax({
      url: '/HoriWeb/action/getComments.php',
      type: 'POST',
      data: {id: btnId},
      success: function(data){
        //Creation de commentaire pour chaque ligne récupérer]);
        console.log('Tableau JSON complet : ' + JSON.stringify(data));
        for(var i = 0; i < data.length; i++){
          var comment = data[i];
          console.log("DEBUG 2" + comment.Username + " " + comment.CreationDate + " " + comment.Text);
          var commentDiv = $('<div class="comment"></div>');
          var commentUser = $('<h4>' + comment.Username + '</h4>');
          var commentDate = $('<div class="date">' + comment.CreationDate + '</div>');
          var commentText = $('<p>' + comment.Text + '</p>');
          commentDiv.append(commentUser);
          commentDiv.append(commentDate);
          commentDiv.append(commentText);
          $('#comment .modal-body').append(commentDiv);
        }

      },
      error: function(){
        console.log('Erreur lors de la récupération des commentaires');
        $('#comment .modal-body').append('<p>Aucun commentaire</p>');
      }
    });
});

//Vider le modal à chaque fermeture
$('#comment').on('hidden.bs.modal', function(){
  $('#comment .modal-body').empty();
  click = false;
});









$('#islike').click(function() {
    var postID = $(this).data('like-id');
    console.log('ID du post : ' + postID);
    $.ajax({
        url: '/HoriWeb/action/unlike.php',
        type: 'POST',
        data: {id: postID},
        success: function(data){
            console.log('unlike réussi');
            // A FAIRE
        },
        error: function(){
            console.log('Erreur lors du like');
        }
    });
});

$('#like').click(function() {
    var postID = $(this).data('like-id');

    console.log('ID du post like : ' + postID);
    $.ajax({
        url: '/HoriWeb/action/like.php',
        type: 'POST',
        data: {id: postID},
        success: function(data){
            console.log('like réussi');
            // A FAIRE
        },
        error: function(){
            console.log('Erreur lors du like');
        }
    });
});