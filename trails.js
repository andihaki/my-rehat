// BUG: wrong element id — 'searchInput' does not exist (actual id is 'search-box')
const input = document.getElementById("search-box");
const category = document.getElementById("category");
const cards = document.querySelectorAll(".trail-card");
const emptyMsg = document.getElementById("no-results");

function applyFilters() {
  const q = input.value.toLowerCase();
  const currentCategory = category.value;
  let shown = 0;
  cards.forEach(function (card) {
    const matchesText = card.textContent.toLowerCase().includes(q);
    const matchesCategory =
      currentCategory === "all" || card.dataset.category === currentCategory;
    const hit = matchesText && matchesCategory;
    card.style.display = hit ? "" : "none";
    if (hit) shown++;
  });
  emptyMsg.hidden = shown > 0;
}

input.addEventListener("input", applyFilters);
category.addEventListener("change", applyFilters);

document
  .getElementById("booking-form")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    alert("Booking request received!");
  });
