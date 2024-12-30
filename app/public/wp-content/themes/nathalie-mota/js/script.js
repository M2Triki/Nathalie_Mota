console.log("ScriptJS ok");

/* Modal de CONTACT */
document.addEventListener("DOMContentLoaded", function () {
  var modal = document.getElementById("modal-contact");
  var btns = document.querySelectorAll(".open-modal-contact");
  var closeBtn = document.querySelector(".close");

  if (modal && closeBtn) {
    btns.forEach(function (btn) {
      btn.onclick = function (event) {
        event.preventDefault();
        modal.style.display = "block";
      };
    });

    closeBtn.onclick = function () {
      modal.style.display = "none";
    };

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
      $('#modal-contact input[name="ref-photo"]').val(photoRef);
      $("#modal-contact").show();
    } else {
      console.error("Le modal de contact n'a pas été trouvé.");
    }
  });

  $(".close").click(function () {
    $("#modal-contact").hide();
  });
});

function loadPhotos() {
  const category = document.getElementById("categorie").value;
  const format = document.getElementById("format").value;
  const order = document.getElementById("order").value;

  const params = new URLSearchParams({
    categorie: category,
    format: format,
    order: order,
  });

  fetch(`/wp-json/wp/v2/photo_custom_endpoint?${params.toString()}`)
    .then((response) => response.json())
    .then((data) => {
      photoGrid.innerHTML = "";

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

  dropdowns.forEach((dropdown) => {
    const button = dropdown.querySelector(".filter-button");
    const options = dropdown.querySelector(".filter-options");

    button.addEventListener("click", function (e) {
      e.stopPropagation();
      dropdown.classList.toggle("active");

      dropdowns.forEach((d) => {
        if (d !== dropdown) {
          d.classList.remove("active");
        }
      });
    });

    options.addEventListener("click", function (e) {
      if (e.target.tagName === "LI") {
        const selectedValue = e.target.textContent;

        button.textContent = selectedValue;

        dropdown.classList.remove("active");
      }
    });
  });

  // Fermer les dropdowns si clic en dehors
  document.addEventListener("click", function () {
    dropdowns.forEach((dropdown) => dropdown.classList.remove("active"));
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter-options li");
  const photoGrid = document.getElementById("photo-grid");

  function loadPhotos() {
    const category =
      document.querySelector("[data-category].selected")?.dataset.category ||
      "";
    const format =
      document.querySelector("[data-format].selected")?.dataset.format || "";
    const order =
      document.querySelector("[data-sort].selected")?.dataset.sort || "DESC";

    const data = new FormData();
    data.append("action", "load_photos");
    data.append("nonce", nathalieMota.nonce);
    data.append("category", category);
    data.append("format", format);
    data.append("order", order);

    fetch(nathalieMota.ajax_url, {
      // Utilisation de l'URL AJAX
      method: "POST",
      body: data,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.success) {
          photoGrid.innerHTML = result.data.html;
          document.dispatchEvent(new Event("galleryUpdated"));
        } else {
          console.error("Erreur lors du chargement des photos.");
        }
      })
      .catch((error) => console.error("Erreur AJAX :", error));
  }

  filters.forEach((filter) => {
    filter.addEventListener("click", function () {
      const type = this.dataset.category
        ? "data-category"
        : this.dataset.format
        ? "data-format"
        : "data-sort";

      document
        .querySelectorAll(`[${type}]`)
        .forEach((f) => f.classList.remove("selected"));
      this.classList.add("selected");

      loadPhotos();
    });
  });
});

// Fleches de navigation sur les pages de photos
document.addEventListener("DOMContentLoaded", function () {
  const currentThumbnail = document.querySelector(".current-thumbnail");
  const prevThumbnail = document.querySelector(".prev-thumbnail");
  const nextThumbnail = document.querySelector(".next-thumbnail");
  const prevLink = document.querySelector(".prev-link");
  const nextLink = document.querySelector(".next-link");

  function showCurrentThumbnail() {
    if (currentThumbnail) currentThumbnail.style.display = "block";
    if (prevThumbnail) prevThumbnail.style.display = "none";
    if (nextThumbnail) nextThumbnail.style.display = "none";
  }

  function showPrevThumbnail() {
    if (currentThumbnail) currentThumbnail.style.display = "none";
    if (prevThumbnail) prevThumbnail.style.display = "block";
    if (nextThumbnail) nextThumbnail.style.display = "none";
  }

  function showNextThumbnail() {
    if (currentThumbnail) currentThumbnail.style.display = "none";
    if (prevThumbnail) prevThumbnail.style.display = "none";
    if (nextThumbnail) nextThumbnail.style.display = "block";
  }

  if (prevLink) {
    prevLink.addEventListener("mouseover", showPrevThumbnail);
    prevLink.addEventListener("mouseout", showCurrentThumbnail);
  }

  if (nextLink) {
    nextLink.addEventListener("mouseover", showNextThumbnail);
    nextLink.addEventListener("mouseout", showCurrentThumbnail);
  }

  showCurrentThumbnail();
});

// Modal mobile
document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const menu = document.querySelector(".menu");
  const modal = document.getElementById("modal-contact");
  const closeBtn = document.querySelector(".close");

  menuToggle.addEventListener("click", function () {
    menu.classList.toggle("active");
    menuToggle.classList.toggle("active");
  });

  closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  window.addEventListener("click", function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });
});
