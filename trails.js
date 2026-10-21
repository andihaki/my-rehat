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

function renderConfirmation(rows) {
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

// Name and date come from the server response, not from the form.
function showConfirmation(booking) {
  const data = new FormData(bookingForm);
  const duration = data.get("duration");
  renderConfirmation([
    ["Name", booking.name],
    ["Date", booking.date],
    ["Digital nomad", data.get("digital_nomad") === "yes" ? "Yes" : "No"],
    ["Duration", duration === "daily" ? "Daily" : "Monthly"],
    ["Total", formatRM(calculateTotal(duration))],
  ]);
}

function showError(message) {
  const paragraph = document.createElement("p");
  paragraph.textContent = message;
  trailsConfirmation.replaceChildren(paragraph);
  trailsConfirmation.removeAttribute("hidden");
}

bookingForm.addEventListener("change", function (e) {
  if (e.target.name === "duration") updateTotal();
});

bookingForm.addEventListener("input", function () {
  trailsConfirmation.setAttribute("hidden", "");
});

bookingForm.addEventListener("submit", async function (e) {
  e.preventDefault();

  const button = bookingForm.querySelector('button[type="submit"]');
  button.disabled = true;

  try {
    const response = await fetch(bookingForm.action, {
      method: "POST",
      body: new FormData(bookingForm),
      headers: { "X-Requested-With": "XMLHttpRequest" },
      credentials: "same-origin",
    });

    const payload = await response.json();

    if (!response.ok || !payload.success) {
      const message = payload.data && payload.data.message;
      throw new Error(message || "Booking failed. Please try again.");
    }

    showConfirmation(payload.data.booking);
  } catch (error) {
    showError(error.message || "Booking failed. Please try again.");
  } finally {
    button.disabled = false;
  }
});
