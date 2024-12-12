console.log("Lightbox JS ok");

document.addEventListener("DOMContentLoaded", () => {
  const lightbox = document.getElementById("lightbox");
  const lightboxImage = lightbox.querySelector(".lightbox__image");
  const lightboxReference = lightbox.querySelector(".lightbox__reference");
  const lightboxCategory = lightbox.querySelector(".lightbox__category");
  const closeBtn = lightbox.querySelector(".lightbox__close");
  const prevBtn = lightbox.querySelector(".lightbox__prev");
  const nextBtn = lightbox.querySelector(".lightbox__next");

  let currentPhotoIndex = 0;
  let photoItems = [];

  function openLightbox(index) {
    const item = photoItems[index];
    const imageUrl = item.querySelector("img").getAttribute("src");
    const reference = item.querySelector(".photo-reference").textContent;
    const category = item.querySelector(".photo-category").textContent;

    lightboxImage.src = imageUrl;
    lightboxReference.textContent = reference;
    lightboxCategory.textContent = category;
    lightbox.classList.add("active");
    currentPhotoIndex = index;
  }

  function closeLightbox() {
    lightbox.classList.remove("active");
    lightboxImage.src = "";
  }

  function navigateLightbox(direction) {
    currentPhotoIndex =
      (currentPhotoIndex + direction + photoItems.length) % photoItems.length;
    openLightbox(currentPhotoIndex);
  }

  function initLightboxEvents() {
    photoItems = Array.from(document.querySelectorAll(".photo-item"));

    photoItems.forEach((item, index) => {
      const fullscreenBtn = item.querySelector(".photo-fullscreen");
      fullscreenBtn.addEventListener("click", (e) => {
        e.preventDefault();
        openLightbox(index);
      });
    });

    // Boutons navigation
    prevBtn.addEventListener("click", () => navigateLightbox(-1));
    nextBtn.addEventListener("click", () => navigateLightbox(1));
    closeBtn.addEventListener("click", closeLightbox);

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        closeLightbox();
      }
    });
  }

  document.addEventListener("galleryUpdated", initLightboxEvents);

  initLightboxEvents();
});
