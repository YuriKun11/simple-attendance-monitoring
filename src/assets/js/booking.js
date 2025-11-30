document.addEventListener('DOMContentLoaded', () => {
    const transportRadios = document.querySelectorAll('input[name="transport_mode"]');
    const labels = document.querySelectorAll('.transport-label');
    const transportDisplay = document.getElementById('transport-display');
    const routeMapInfo = document.getElementById('route-map-info');

    transportRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            labels.forEach(label => label.classList.remove('selected'));
            const selectedLabel = document.querySelector(`label[for="${radio.id}"]`);
            selectedLabel.classList.add('selected');
            const modeName = selectedLabel.querySelector('.font-bold').textContent;
            transportDisplay.innerHTML = `
                <span class="text-xl font-bold text-teal-600 block">${modeName}</span>
                <span class="text-xs text-gray-500 uppercase tracking-wider">Selected Mode</span>
            `;
            routeMapInfo.innerHTML = `<span class="font-semibold text-teal-700">Real-time schedule and fare for <strong>${modeName}</strong> loaded.</span>`;
        });
    });
});