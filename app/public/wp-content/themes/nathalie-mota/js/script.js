console.log("ScriptJS ok");

/* Modal de CONTACT */
document.addEventListener("DOMContentLoaded", function () {
  // Récupérer les éléments du modal de contact global
  var modal = document.getElementById("modal-contact");
  var btns = document.querySelectorAll(".open-modal-contact");
  var closeBtn = document.querySelector(".close");

  // Vérifie si le modal et le bouton de fermeture existent
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

// Pré-remplir le champ "Réf photo" dans la PopUp contact
jQuery(document).ready(function ($) {
  $(".contact-modal-trigger").click(function (e) {
    e.preventDefault();
    var photoRef = $(this).data("photo-id");
    if ($("#modal-contact").length) {
      // Remplir le champ de la référence
      $('#modal-contact input[name="ref-photo"]').val(photoRef);
      // Afficher le modal de contact
      $("#modal-contact").show();
    } else {
      console.error("Le modal de contact n'a pas été trouvé.");
    }
  });

  // Fermer le modal au clic sur le bouton de fermeture
  $(".close").click(function () {
    $("#modal-contact").hide();
  });

  // Fermer le modal quand on clique en dehors
  $(window).click(function (event) {
    if ($(event.target).is("#modal-contact")) {
      $("#modal-contact").hide();
    }
  });
});

// Recharger automatiquement la front page quand les filtres sont selectionées
function loadPhotos() {
  const category = document.getElementById("categorie").value;
  const format = document.getElementById("format").value;
  const order = document.getElementById("order").value;

  const params = new URLSearchParams({
    categorie: category,
    format: format,
    order: order,
  });

  // Modifier l'URL pour correspondre au nom de votre CPT
  fetch(`/wp-json/wp/v2/photo_custom_endpoint?${params.toString()}`)
    .then((response) => response.json())
    .then((data) => {
      // Réinitialiser la galerie
      photoGrid.innerHTML = "";

      // Ajouter les photos retournées par la requête
      data.forEach((photo) => {
        const photoItem = document.createElement("div");
        photoItem.classList.add("photo-item");
        photoItem.innerHTML = `
                  <a href="${photo.link}">
                      <img src="${photo.featured_media_src_url}" alt="${photo.title.rendered}">
                  </a>
              `;
        photoGrid.appendChild(photoItem);
      });
    })
    .catch((error) =>
      console.error("Erreur lors du chargement des photos :", error)
    );
}

/* Filtres front page */
document.addEventListener("DOMContentLoaded", function () {
  const dropdowns = document.querySelectorAll(".filter-dropdown");

  // Gérer les dropdowns
  dropdowns.forEach((dropdown) => {
    const button = dropdown.querySelector(".filter-button");
    const options = dropdown.querySelector(".filter-options");

    // Ouvrir/fermer le dropdown au clic sur le bouton
    button.addEventListener("click", function (e) {
      e.stopPropagation(); // Empêcher la propagation
      dropdown.classList.toggle("active");

      // Fermer les autres dropdowns
      dropdowns.forEach((d) => {
        if (d !== dropdown) {
          d.classList.remove("active");
        }
      });
    });

    // Gérer la sélection dans les options
    options.addEventListener("click", function (e) {
      if (e.target.tagName === "LI") {
        const selectedValue = e.target.textContent;

        // Remplacer le texte du bouton par la valeur sélectionnée
        button.textContent = selectedValue;

        // Fermer le dropdown
        dropdown.classList.remove("active");

        // Charger dynamiquement les photos (si nécessaire)
        console.log("Option sélectionnée :", selectedValue);
      }
    });
  });

  // Fermer les dropdowns si clic en dehors
  document.addEventListener("click", function () {
    dropdowns.forEach((dropdown) => dropdown.classList.remove("active"));
  });
});

/* Charger photos quand les filtres sont selectionnées */
document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter-options li");
  const photoGrid = document.getElementById("photo-grid");

  // Fonction pour charger les photos
  function loadPhotos() {
    const category =
      document.querySelector("[data-category].selected")?.dataset.category ||
      "";
    const format =
      document.querySelector("[data-format].selected")?.dataset.format || "";
    const order =
      document.querySelector("[data-sort].selected")?.dataset.sort || "desc";

    const params = new URLSearchParams({
      categorie: category,
      format: format,
      order: order,
    });

    fetch(`/wp-json/wp/v2/filtered-photos?${params.toString()}`)
      .then((response) => response.json())
      .then((data) => {
        photoGrid.innerHTML = ""; // Réinitialiser la galerie

        // Ajouter les nouvelles photos
        if (data.length > 0) {
          data.forEach((photo) => {
            const photoItem = document.createElement("div");
            photoItem.classList.add("photo-item");
            photoItem.innerHTML = `
                          <a href="${photo.link}">
                              <img src="${photo.thumbnail}" alt="${photo.title}">
                          </a>
                      `;
            photoGrid.appendChild(photoItem);
          });
        } else {
          photoGrid.innerHTML = "<p>Aucune photo trouvée.</p>";
        }
      })
      .catch((error) =>
        console.error("Erreur lors du chargement des photos :", error)
      );
  }

  // Ajouter des événements de clic pour les filtres
  filters.forEach((filter) => {
    filter.addEventListener("click", function () {
      // Ajouter la classe "selected" au filtre sélectionné
      const filterType = this.dataset.category
        ? "data-category"
        : this.dataset.format
        ? "data-format"
        : "data-sort";

      // Supprimer les "selected" des filtres du même type
      document
        .querySelectorAll(`[${filterType}]`)
        .forEach((f) => f.classList.remove("selected"));

      this.classList.add("selected"); // Ajouter "selected" au filtre cliqué

      loadPhotos(); // Recharger les photos
    });
  });
});
