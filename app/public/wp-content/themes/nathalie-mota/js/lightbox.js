document.addEventListener("DOMContentLoaded", () => {
  const lightbox = document.getElementById("lightbox");
  const lightboxImage = lightbox.querySelector(".lightbox__image");
  const lightboxReference = lightbox.querySelector(".lightbox__reference");
  const lightboxCategory = lightbox.querySelector(".lightbox__category");
  const closeBtn = lightbox.querySelector(".lightbox__close");
  const prevBtn = lightbox.querySelector(".lightbox__prev");
  const nextBtn = lightbox.querySelector(".lightbox__next");

  let currentPhotoIndex = 0;

  function initLightboxEvents() {
    const photoItems = document.querySelectorAll(".photo-item");

    photoItems.forEach((item, index) => {
      const fullscreenBtn = item.querySelector(".photo-fullscreen");
      fullscreenBtn.addEventListener("click", () => {
        currentPhotoIndex = index;
        openLightbox(item);
      });
    });
  }

  function openLightbox(item) {
    const imageUrl = item.querySelector("img").getAttribute("src");
    const reference = item.querySelector(".photo-reference").textContent;
    const category = item.querySelector(".photo-category").textContent;

    lightboxImage.src = imageUrl;
    lightboxReference.textContent = reference;
    lightboxCategory.textContent = category;

    lightbox.classList.add("active");
  }

  closeBtn.addEventListener("click", () => {
    lightbox.classList.remove("active");
    lightboxImage.src = "";
  });

  function navigateLightbox(direction) {
    const photoItems = document.querySelectorAll(".photo-item");
    currentPhotoIndex =
      (currentPhotoIndex + direction + photoItems.length) % photoItems.length;
    openLightbox(photoItems[currentPhotoIndex]);
  }

  prevBtn.addEventListener("click", () => navigateLightbox(-1));
  nextBtn.addEventListener("click", () => navigateLightbox(1));

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      lightbox.classList.remove("active");
      lightboxImage.src = "";
    }
  });

  // Ré-initialiser après filtrage AJAX
  document.addEventListener("galleryUpdated", () => {
    initLightboxEvents();
  });

  initLightboxEvents();
});
