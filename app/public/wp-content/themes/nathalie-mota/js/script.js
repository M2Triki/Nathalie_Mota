console.log("ScriptJS functionne");

document.addEventListener("DOMContentLoaded", function () {
  // Récupérer les éléments
  var modal = document.getElementById("modal-contact");
  var btns = document.querySelectorAll(".open-modal-contact");
  var closeBtn = document.querySelector(".close");

  // Vérifie si le modal existe
  if (modal && closeBtn) {
    // Ouvrir le modal quand on clique sur un élément avec la classe "open-modal-contact"
    btns.forEach(function (btn) {
      btn.onclick = function (event) {
        event.preventDefault();
        modal.style.display = "block";
      };
    });

    // Fermer le modal quand on clique sur le bouton de fermeture
    closeBtn.onclick = function () {
      modal.style.display = "none";
    };

    // Fermer le modal quand on clique en dehors du modal
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  }
});

// Pré remplir le champ "Réf photo" dans la PopUp contact
jQuery(document).ready(function ($) {
  $(".contact-modal-trigger").click(function (e) {
    e.preventDefault();
    var photoRef = $(this).data("photo-id");
    $('#modal-contact input[name="ref-photo"]').val(photoRef);
    $("#modal-contact").show();
  });

  $(".close").click(function () {
    $("#modal-contact").hide();
  });
});
