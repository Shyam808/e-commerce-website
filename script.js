function scrollRight() {
  const container = document.getElementById("scrollcontainer");
  container.scrollBy({ left: 300, behavior: "smooth" });
}

const container = document.getElementById("autoScrollContainer");

let scroll = setInterval(autoScroll, 2000);
function autoScroll() {
  container.scrollBy({
    left: 300,
    behavior: "smooth",
  });

  // When reach end reset to start
  if (container.scrollLeft >= container.scrollWidth - container.clientWidth) {
    container.scrollLeft = 0;
  }
}

// Pause
container.addEventListener("mouseenter", () => clearInterval(scroll));

container.addEventListener("mouseleave", () => {
  scroll = setInterval(autoScroll, 2000);
});
