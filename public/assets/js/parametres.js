document.addEventListener("DOMContentLoaded", () => {
  feather.replace();

  document.querySelectorAll(".mdp-icon").forEach((icon) => {
    const passwordInput = icon.previousElementSibling;
    const eye = icon.querySelector(".eye");
    const eyeOff = icon.querySelector(".eye-off");

    // Révèle le mot de passe
    eye.addEventListener("click", () => {
      passwordInput.type = "text";
      eye.style.display = "none";
      eyeOff.style.display = "block";
    });

    // Masque le mot de passe
    eyeOff.addEventListener("click", () => {
      passwordInput.type = "password";
      eyeOff.style.display = "none";
      eye.style.display = "block";
    });
  });
});
