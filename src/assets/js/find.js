//WHERE ARE YOU GOING SECTION
const attractions = [
    "Ma-Cho Temple",
    "Saint William the Hermit Cathedral",
    "Pindangan Ruins",
    "Pagoda Hill",
    "Poro Point Lighthouse",
    "SM City La Union",
    "Urbiztondo Beach",
    "Tangadan Falls"
];

const input = document.getElementById("destination-search");
const options = document.getElementById("destination-options");

function showOptions(filter = "") {
    options.innerHTML = "";
    const filtered = attractions.filter(a => a.toLowerCase().includes(filter.toLowerCase()));
    filtered.forEach(item => {
        const div = document.createElement("div");
        div.textContent = item;
        div.className = "p-2 cursor-pointer hover:bg-blue-100 transition";
        div.addEventListener("click", () => {
            input.value = item;
            options.classList.add("hidden");
        });
        options.appendChild(div);
    });
    options.classList.toggle("hidden", filtered.length === 0);
}

input.addEventListener("focus", () => showOptions(input.value));
input.addEventListener("input", () => showOptions(input.value));

document.addEventListener("click", e => {
    if (!input.contains(e.target) && !options.contains(e.target)) {
        options.classList.add("hidden");
    }
});