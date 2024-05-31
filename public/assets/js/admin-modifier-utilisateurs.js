function rechercherUtilisateurs() {
  // Récupérer la valeur du champ de recherche et la convertir en minuscules
  let rechercheValue = document
    .getElementById("recherche-utilisateur")
    .value.toLowerCase();

  // Sélectionner tous les éléments de la liste des utilisateurs
  let utilisateurs = document.querySelectorAll(
    ".container-modifier table tbody tr"
  );

  // Parcourir chaque utilisateur pour vérifier s'il correspond à la recherche
  utilisateurs.forEach(function (utilisateur) {
    // Récupérer le prénom, le nom et l'email de l'utilisateur et les convertir en minuscules
    var utilisateurPrenom = utilisateur
      .querySelector("td:nth-child(1)")
      .textContent.toLowerCase();
    var utilisateurNom = utilisateur
      .querySelector("td:nth-child(2)")
      .textContent.toLowerCase();
    var utilisateurEmail = utilisateur
      .querySelector("td:nth-child(3)")
      .textContent.toLowerCase();

    // Vérifier si le prénom, le nom ou l'email de l'utilisateur contient la valeur de recherche
    if (
      utilisateurPrenom.includes(rechercheValue) ||
      utilisateurNom.includes(rechercheValue) ||
      utilisateurEmail.includes(rechercheValue)
    ) {
      // Si oui, afficher l'utilisateur
      utilisateur.style.display = "";
    } else {
      // Sinon, masquer l'utilisateur
      utilisateur.style.display = "none";
    }
  });
}

document
  .getElementById("recherche-button")
  .addEventListener("click", function () {
    rechercherUtilisateurs();
  });

document
  .getElementById("recherche-utilisateur")
  .addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      rechercherUtilisateurs();
    }
  });
