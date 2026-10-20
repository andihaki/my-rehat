// BUG: wrong element id — 'searchInput' does not exist (actual id is 'search-box')
const input = document.getElementById("search-box");
const mainSearch = document.getElementById("main-search");
const category = document.getElementById("category");
const cards = document.querySelectorAll(".trail-card");
const emptyMsg = document.getElementById("trails-no-results");
const bookingForm = document.getElementById("booking-form");
const trailsTotal = document.getElementById("trails-total");
const trailsConfirmation = document.getElementById("trails-confirmation");

const DAILY_PRICE = 350;
const DAYS_PER_MONTH = 30;
const MONTHLY_RATE = 0.8;

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

input.addEventListener("input", function () {
  if (mainSearch) mainSearch.value = input.value;
  applyFilters();
});

if (mainSearch) {
  mainSearch.addEventListener("input", function () {
    input.value = mainSearch.value;
    applyFilters();
  });
}

category.addEventListener("change", applyFilters);

function formatRM(amount) {
  return "RM " + amount.toLocaleString("en-MY", {});
}

function calculateTotal(duration) {
  return duration === "daily"
    ? DAILY_PRICE
    : DAILY_PRICE * DAYS_PER_MONTH * MONTHLY_RATE;
}

function updateTotal() {
  const picked = bookingForm.querySelector('input[name="duration"]:checked');
  if (!picked) {
    trailsTotal.textContent = "Total: -";
    return;
  }
  trailsTotal.textContent = `Total: ${calculateTotal(picked.value)}`;
}

function showConfirmation() {
  const data = new FormData(bookingForm);
  const duration = data.get("duration");
  const rows = [
    ["Name", data.get("name")],
    ["Date", data.get("date")],
    ["Digital nomad", data.get("digital_nomad") === "yes" ? "Yes" : "No"],
    ["Duration", duration === "daily" ? "Daily" : "Monthly"],
    ["Total", formatRM(calculateTotal(duration))],
  ];

  const list = document.createElement("dl");
  rows.forEach(function (row) {
    const term = document.createElement("dt");
    term.textContent = row[0];
    const detail = document.createElement("dd");
    detail.textContent = row[1];
    list.append(term, detail);
  });

  trailsConfirmation.replaceChildren(list);
  trailsConfirmation.removeAttribute("hidden");
}

bookingForm.addEventListener("change", function (e) {
  if (e.target.name === "duration") updateTotal();
});

bookingForm.addEventListener("input", function () {
  trailsConfirmation.setAttribute("hidden", "");
});

bookingForm.addEventListener("submit", function (e) {
  e.preventDefault();
  showConfirmation();
});
