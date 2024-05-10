





$(document).ready(function() {






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



  $('.deleteNotif').click(function(){
    var notificationId = $(this).data('id');
    console.log('Suppression de la notification ' + notificationId);
    $.ajax({
      url: '/HoriWeb/action/deleteNotification.php',
      type: 'POST',
      data: {id: notificationId},
      success: function(data){
        console.log('Notification supprimée');
        $('#notification' + notificationId).remove();
      },
      error: function(){
        console.log('Erreur lors de la suppression de la notification');
      }
    });
  });


  $('#islike').click(function() {
    var $this = $(this); // Stocker une référence à $(this)

    var postID = $this.data('like-id');
    $.ajax({
        url: '/HoriWeb/action/unlike.php',
        type: 'POST',
        data: { id: postID },
        success: function(data) {
            
            // Changer l'icone
            $this.attr('src', '/HoriWeb/icon/like.png');
            
            // Ajouter un au compteur numberOfLike
            var numberOfLike = parseInt($this.closest('div').find('span').text());
            numberOfLike--;
            $this.closest('div').find('span').text(numberOfLike);
            $this.attr('id', 'like');

        },
        error: function() {
            console.log('Erreur lors du like');
        }
    });
  });


  $('#like').click(function() {
      var $this = $(this);
      var postID = $(this).data('like-id');
      $.ajax({
          url: '/HoriWeb/action/like.php',
          type: 'POST',
          data: {id: postID},
          success: function(data){
            
            // Changer l'icone
            $this.attr('src', '/HoriWeb/icon/islike.png');
            
            // Ajouter un au compteur numberOfLike
            var numberOfLike = parseInt($this.closest('div').find('span').text());
            numberOfLike++;
            $this.closest('div').find('span').text(numberOfLike);

            $this.attr('id', 'islike');
          },
          error: function(){
              console.log('Erreur lors du like');
          }
      });
  });




  
});

