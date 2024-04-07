function errorPost() {
    console.log('Publication');
    if (hasError === '1') {
      alert('Erreur lors de la publication. \nMerci de verifier si vous étes connecté ou les informations saisies');
      console.log('Publication raté');
    } else if (hasError === '0') {
      alert('Publication réussie.');
      console.log('Publication réussie');
    }
}