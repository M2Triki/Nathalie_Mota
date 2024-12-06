document.addEventListener("DOMContentLoaded", () => {
  const lightbox = document.getElementById("lightbox");
  const lightboxContent = document.getElementById(
    "lightbox__container_content"
  );
  const closeButton = document.querySelector(".lightbox__close");
  const nextButton = document.querySelector(".lightbox__next");
  const prevButton = document.querySelector(".lightbox__prev");
  const galleryItems = document.querySelectorAll(".gallery-item"); // Adaptez à vos photos
  let currentIndex = 0;

  function openLightbox(index) {
    currentIndex = index;
    const imageSrc = galleryItems[currentIndex].dataset.image; // Ajoutez data-image à vos éléments
    lightboxContent.innerHTML = `<img src="${imageSrc}" alt="Photo" style="max-width:100%; max-height:100%;">`;
    lightbox.classList.add("active");
  }

  function closeLightbox() {
    lightbox.classList.remove("active");
  }

  function showNext() {
    if (currentIndex < galleryItems.length - 1) {
      openLightbox(currentIndex + 1);
    }
  }

  function showPrev() {
    if (currentIndex > 0) {
      openLightbox(currentIndex - 1);
    }
  }

  galleryItems.forEach((item, index) => {
    item.addEventListener("click", () => openLightbox(index));
  });

  closeButton.addEventListener("click", closeLightbox);
  nextButton.addEventListener("click", showNext);
  prevButton.addEventListener("click", showPrev);

  lightbox.addEventListener("click", (e) => {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });
});
