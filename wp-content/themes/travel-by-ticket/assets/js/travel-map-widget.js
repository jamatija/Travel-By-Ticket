(function () {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBusMaps);
  } else {
    initBusMaps();
  }

  function initBusMaps() {
    const pageLang = (document.documentElement.getAttribute('lang') || '').slice(0, 2).toLowerCase();

    const labelsByLang = {
      en: 'Bus station',
      sr: 'Autobuska stanica',
      bs: 'Autobuska stanica' 
    };
    const activeLang = ['en', 'sr', 'bs'].includes(pageLang) ? pageLang : 'sr';
    const label = labelsByLang[activeLang] || labelsByLang.sr;

    document.querySelectorAll('.tw-bus-map').forEach(function (el) {
      const map = L.map(el, { preferCanvas: true });

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
      }).addTo(map);

      const montenegroBounds = L.latLngBounds([41.8, 18.4], [43.6, 20.4]);
      map.fitBounds(montenegroBounds);
      map.setMaxBounds(montenegroBounds.pad(0.2));
      map.setMinZoom(map.getZoom());
      map.on('drag', () => map.panInsideBounds(map.options.maxBounds, { animate: false }));

      // 2) Ikonica (SVG)
      const busSvg = encodeURIComponent(`
        <svg width="57" height="60" viewBox="0 0 57 60" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g filter="url(#filter0_f_540_283)">
            <path d="M44.6879 45.6108C39.8031 44.5369 34.1598 44 27.7276 44C21.2954 44 25.533 45.0424 20.6482 46.1163C15.7634 47.1901 19.1318 48.1358 19.1318 49.9498C19.1318 51.1615 16.6131 51.043 20.6484 52.4651C24.6837 53.8873 19.1314 52.4651 24.1881 57C32.3194 55.3457 41.9573 55.3191 45.9622 53.8969C49.9975 52.4748 52 51.1615 52 49.9498C52 48.1358 49.5728 46.6919 44.6879 45.6108Z" fill="black" fill-opacity="0.4"/>
          </g>
          <path d="M24 1.5C29.7835 1.5 34.8644 3.44169 39.3252 7.37695L39.7549 7.76465C44.2303 11.9085 46.4999 17.4541 46.5 24.5996C46.5 29.2092 44.6771 34.3484 40.7891 40.0781L40.7861 40.082C37.0895 45.571 31.4921 51.5494 23.999 58.0205C16.5113 51.552 10.9386 45.5716 7.21094 40.0781C3.32288 34.3484 1.5 29.2092 1.5 24.5996C1.50008 17.4489 3.77281 11.8759 8.24512 7.76465C12.8087 3.56958 18.0299 1.5 24 1.5Z" fill="#480E66" stroke="white" stroke-width="3"/>
          <path d="M17.7665 37C17.5743 37 17.4131 36.9352 17.2831 36.8055C17.153 36.6759 17.088 36.5152 17.088 36.3235V33.758C16.646 33.5673 16.1875 33.161 15.7125 32.5394C15.2375 31.9175 15 31.2015 15 30.3916V18.0588C15 16.6551 15.7619 15.6277 17.2858 14.9765C18.8096 14.3255 21.214 14 24.499 14C27.9029 14 30.3374 14.3129 31.8024 14.9386C33.2675 15.5643 34 16.6044 34 18.0588V30.3916C34 31.2015 33.7625 31.9175 33.2875 32.5394C32.8125 33.161 32.354 33.5673 31.912 33.758V36.3235C31.912 36.5152 31.847 36.6759 31.7169 36.8055C31.5869 36.9352 31.4257 37 31.2335 37H30.9203C30.728 37 30.5669 36.9352 30.4368 36.8055C30.3068 36.6759 30.2417 36.5152 30.2417 36.3235V34.2941H18.7583V36.3235C18.7583 36.5152 18.6932 36.6759 18.5632 36.8055C18.4331 36.9352 18.272 37 18.0797 37H17.7665ZM24.5156 17.4344H32.5333H16.4979H24.5156ZM29.9286 26.1765H16.3571H32.6429H29.9286ZM16.3571 24.8235H32.6429V18.7874H16.3571V24.8235ZM19.7561 31.068C20.1784 31.068 20.5352 30.9207 20.8266 30.626C21.1181 30.3312 21.2639 29.9735 21.2639 29.5527C21.2639 29.1317 21.1161 28.776 20.8204 28.4856C20.5248 28.1949 20.166 28.0496 19.7439 28.0496C19.3216 28.0496 18.9648 28.197 18.6734 28.4917C18.3819 28.7864 18.2361 29.1441 18.2361 29.5649C18.2361 29.9859 18.3839 30.3416 18.6796 30.632C18.9752 30.9227 19.334 31.068 19.7561 31.068ZM29.2561 31.068C29.6784 31.068 30.0352 30.9207 30.3266 30.626C30.6181 30.3312 30.7639 29.9735 30.7639 29.5527C30.7639 29.1317 30.6161 28.776 30.3204 28.4856C30.0248 28.1949 29.666 28.0496 29.2439 28.0496C28.8216 28.0496 28.4648 28.197 28.1734 28.4917C27.8819 28.7864 27.7361 29.1441 27.7361 29.5649C27.7361 29.9859 27.8839 30.3416 28.1796 30.632C28.4752 30.9227 28.834 31.068 29.2561 31.068ZM16.4979 17.4344H32.5333C32.2983 16.7388 31.5731 16.218 30.3578 15.8721C29.1424 15.526 27.1951 15.3529 24.5156 15.3529C21.8518 15.3529 19.9122 15.5286 18.6969 15.8799C17.4815 16.231 16.7486 16.7492 16.4979 17.4344ZM19.0714 32.9412H29.9286C30.675 32.9412 31.314 32.6762 31.8455 32.1463C32.3771 31.6164 32.6429 30.9794 32.6429 30.2353V26.1765H16.3571V30.2353C16.3571 30.9794 16.6229 31.6164 17.1545 32.1463C17.686 32.6762 18.325 32.9412 19.0714 32.9412Z" fill="#F4B821"/>
          <defs>
            <filter id="filter0_f_540_283" x="10" y="36" width="50" height="29" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
              <feFlood flood-opacity="0" result="BackgroundImageFix"/>
              <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
              <feGaussianBlur stdDeviation="4" result="effect1_foregroundBlur_540_283"/>
            </filter>
          </defs>
        </svg>
      `);

      const busIcon = L.icon({
        iconUrl: `data:image/svg+xml;utf8,${busSvg}`,
        iconSize: [34, 34],
        iconAnchor: [17, 30],
        popupAnchor: [0, -26]
      });

      const overlays = {};
      const layersControl = L.control.layers(null, overlays, { collapsed: false }).addTo(map);

        setTimeout(() => {
        const controlContainer = document.querySelector('.leaflet-control-layers-overlays');
        if (!controlContainer) return;

        controlContainer.querySelectorAll('input[type="checkbox"]').forEach(input => {
            const label = input.nextSibling;

            // Sakrij checkbox
            input.style.display = 'none';

            // Napravi SVG ikonicu (možeš staviti svoju)
            const svgIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svgIcon.setAttribute('width', '13');
            svgIcon.setAttribute('height', '16');
            svgIcon.setAttribute('viewBox', '0 0 13 16');
            svgIcon.style.cursor = 'pointer';
            svgIcon.innerHTML = `
            <path d="M11.0419 1.776C9.73375 0.592 8.2225 0 6.5 0C4.7775 0 3.26625 0.592 1.95813 1.776C0.65 2.96 0 4.56 0 6.56C0 7.896 0.53625 9.344 1.61688 10.912C2.6975 12.48 4.3225 14.176 6.5 16C8.6775 14.176 10.3106 12.48 11.3831 10.912C12.4637 9.344 13 7.896 13 6.56C13 4.56 12.35 2.968 11.0419 1.776Z" fill="#F4B821"/>
            `;

            svgIcon.addEventListener('click', () => {
            input.click();
            svgIcon.classList.toggle('active', input.checked);
            });

            if (input.checked) svgIcon.classList.add('active');

            svgIcon.style.marginRight = '6px';
            svgIcon.classList.add('tw-layer-icon');

            label.parentNode.insertBefore(svgIcon, label);
        });

        const style = document.createElement('style');
        style.textContent = `
            .tw-layer-icon.active circle {
            fill: #480E66;
            stroke: #F4B821;
            }
        `;
        document.head.appendChild(style);
        }, 100);


      const manualStations = {
        "Podgorica": [{ name: `${label} Podgorica`, lat: 42.4329, lon: 19.2597 }],
        "Kotor":     [{ name: `${label} Kotor`,     lat: 42.4247, lon: 18.7682 }],
        "Budva":     [{ name: `${label} Budva`,     lat: 42.2876, lon: 18.8410 }],
        "Tivat":     [{ name: `${label} Tivat`,     lat: 42.4323, lon: 18.7068 }],
        "Žabljak":   [{ name: `${label} Žabljak`,   lat: 43.1544, lon: 19.1235 }],
        "Nikšić":    [{ name: `${label} Nikšić`,    lat: 42.7734, lon: 18.9445 }]
      };

    const allMarkers = {};
    Object.entries(manualStations).forEach(([city, arr]) => {
    arr.forEach(station => {
        const marker = L.marker([station.lat, station.lon], { icon: busIcon })
        .bindPopup(`<b>${station.name}</b><br/>${city}`)
        .addTo(map);
        allMarkers[city] = { marker, lat: station.lat, lon: station.lon };
    });
    });

    Object.keys(manualStations).forEach(city => {
    const dummyLayer = L.layerGroup();
    overlays[city] = dummyLayer;
    layersControl.addOverlay(dummyLayer, city);
    });

    setTimeout(() => {
        const controlContainer = document.querySelector('.leaflet-control-layers-overlays');
        if (!controlContainer) return;

        controlContainer.querySelectorAll('label').forEach(label => {
            const cityName = label.textContent.trim();
            const input = label.querySelector('input[type="checkbox"]');
            
            if (input) {
            input.style.display = 'none';
            }

            label.style.cursor = 'pointer';
            label.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const station = allMarkers[cityName];
            if (station) {
                map.setView([station.lat, station.lon], 12, {
                animate: true,
                duration: 1
                });
                setTimeout(() => {
                station.marker.openPopup();
                }, 1000);
            }
            });
        });
    }, 100);
        });
    }
  
})();
