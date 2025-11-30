const LA_UNION_MAP_LOCATIONS = {
    "Ma-Cho Temple": "https://maps.google.com/maps?q=Ma-Cho%20Temple,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Saint William the Hermit Cathedral": "https://maps.google.com/maps?q=Saint%20William%20the%20Hermit%20Cathedral,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Pindangan Ruins": "https://maps.google.com/maps?q=Pindangan%20Ruins,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Pagoda Hill": "https://maps.google.com/maps?q=Pagoda%20Hill,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Poro Point Lighthouse": "https://maps.google.com/maps?q=Poro%20Point%20Lighthouse,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "SM City La Union": "https://maps.google.com/maps?q=SM%20City%20La%20Union,%20San%20Fernando,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Urbiztondo Beach": "https://maps.google.com/maps?q=Urbiztondo%20Beach,%20San%20Juan,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed",
    "Tangadan Falls": "https://maps.google.com/maps?q=Tangadan%20Falls,%20San%20Gabriel,%20La%20Union&t=&z=16&ie=UTF8&iwloc=&output=embed"
};

const TRANSPORT_MODES = [
    { name: 'Motorcycle', slug: 'motor', fare: 50 },
    { name: 'Tricycle', slug: 'tricycle', fare: 80 },
    { name: 'Jeepney', slug: 'jeep', fare: 20 }, 
    { name: 'Taxi', slug: 'taxi', fare: 200 },
    { name: 'Van', slug: 'van', fare: 1500 }, 
    { name: 'Bus', slug: 'bus', fare: 150 }, 
];

const destinationSelect = document.getElementById('destination');
const pickupInput = document.getElementById('pickup');
const mapContainer = document.getElementById('map-preview-container');
const fareEstimateDisplay = document.getElementById('fare-estimate');
const transportRadios = document.querySelectorAll('input[name="transport_mode"]');
const vehicleTypeDisplay = document.getElementById('vehicle-type');
const travelTimeDisplay = document.getElementById('travel-time');
const distanceDisplay = document.getElementById('distance');
const routeInfo = document.getElementById('route-map-info');


/**
 * Updates the map iframe with the selected destination's location.
 * @param {string} destinationName 
 */
function updateMap(destinationName) {
    const mapUrl = LA_UNION_MAP_LOCATIONS[destinationName];

    if (mapUrl) {
        const iframeHtml = `
            <iframe
                class="map-iframe"
                title="Map of ${destinationName}"
                loading="lazy"
                allowfullscreen
                src="${mapUrl}">
            </iframe>
        `;

        mapContainer.innerHTML = iframeHtml;
        mapContainer.classList.remove('bg-gray-200', 'border-dashed', 'border-gray-400');
        routeInfo.textContent = `Showing map for: ${destinationName}. Use the pickup location field to calculate route/fare.`;
    } else {
        mapContainer.innerHTML = `
            <p class="text-gray-500 font-medium p-4 text-center">
                Select a **Destination** above to load the interactive map for that tourist spot.
            </p>
        `;
        mapContainer.classList.add('bg-gray-200', 'border-dashed', 'border-gray-400');
        routeInfo.textContent = "**Enter locations above** to load the map preview and fare details instantly.";
    }
}

function calculateRouteAndFare() {
    const destination = destinationSelect.value;
    const pickup = pickupInput.value.trim();
    const selectedTransportRadio = document.querySelector('input[name="transport_mode"]:checked');
    
    let selectedTransport = null;
    if (selectedTransportRadio) {
        selectedTransport = TRANSPORT_MODES.find(t => t.slug === selectedTransportRadio.value);
    }

    if (selectedTransport) {
        vehicleTypeDisplay.textContent = selectedTransport.name;
    } else {
        vehicleTypeDisplay.textContent = "Select Mode";
    }

    if (pickup && destination && selectedTransport) {
        const baseFare = selectedTransport.fare; 
        const distance = Math.floor(Math.random() * 20) + 5; 
        const time = Math.floor(distance * 2.5) + 5; 

        const estimatedFare = baseFare + (distance * 15) + (Math.random() * 50); 

        distanceDisplay.textContent = `${distance.toFixed(1)} km`;
        travelTimeDisplay.textContent = `${time} min`;
        fareEstimateDisplay.textContent = `₱ ${estimatedFare.toFixed(2)}`;
        routeInfo.textContent = `Route calculated from ${pickup} to ${destination} using ${selectedTransport.name}.`;

    } else if (destination) {
        distanceDisplay.textContent = '-- km';
        travelTimeDisplay.textContent = '-- min';
        fareEstimateDisplay.textContent = '₱ 0.00';
        routeInfo.textContent = `Showing map for: ${destination}. Please enter a Pickup Location and choose a ride.`;
    } else {
        distanceDisplay.textContent = '-- km';
        travelTimeDisplay.textContent = '-- min';
        fareEstimateDisplay.textContent = '₱ 0.00';
        vehicleTypeDisplay.textContent = "Select Mode";
        routeInfo.textContent = "**Enter locations above** to load the map preview and fare details instantly.";
    }
}

destinationSelect.addEventListener('change', (e) => {
    updateMap(e.target.value);
    calculateRouteAndFare();
});

pickupInput.addEventListener('input', calculateRouteAndFare);

transportRadios.forEach(radio => {
    radio.addEventListener('change', calculateRouteAndFare);
});

document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('date');
    if (!dateInput.value) {
        dateInput.value = new Date().toISOString().split('T')[0];
    }
});
