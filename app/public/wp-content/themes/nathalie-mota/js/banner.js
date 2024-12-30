console.log("BannerJS ok");

document.addEventListener("DOMContentLoaded", function () {
  const heroImages = document.querySelectorAll(".hero-image");
  let currentIndex = 0;

  function showNextImage() {
    if (heroImages.length === 0) return;

    heroImages[currentIndex].style.opacity = 0;

    currentIndex = (currentIndex + 1) % heroImages.length;

    heroImages[currentIndex].style.display = "block";
    setTimeout(() => {
      heroImages[currentIndex].style.opacity = 1;
    }, 10);
  }

  heroImages.forEach((img, index) => {
    img.style.transition = "opacity 1s ease-in-out";
    img.style.opacity = 0;
    if (index === 0) {
      img.style.display = "block";
      img.style.opacity = 1;
    }
  });

  setInterval(showNextImage, 5000);
});
