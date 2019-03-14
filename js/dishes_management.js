document.querySelectorAll(".dishesLink").forEach(link =>
  link.addEventListener("click", function() {
    this.parentElement.childNodes[3].classList.toggle("visible");
  })
);
