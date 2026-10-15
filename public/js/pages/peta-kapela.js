document.addEventListener("DOMContentLoaded", function() {
    var mapEl = document.getElementById('full-map-kapela');
    if (!mapEl || !window.L) return;

    // Koordinat pusat Paroki Benlutu / TTS: -9.8541, 124.2872
    var defaultCenter = [-9.8541, 124.2872];
    var map = L.map('full-map-kapela', { center: defaultCenter, zoom: 12 });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    map.attributionControl.setPrefix('SIPAROKI');

    function createChurchIcon(color, name) {
        var c = color || '#0284c7';
        var shortName = (name || '').replace(/^(Santo|Santa|Stu\.|St\.)\s*/i, '').trim();
        if (!shortName) shortName = name || 'Gereja';
        if (shortName.length > 20) shortName = shortName.slice(0, 18) + '...';

        return L.divIcon({
            className: 'church-pin-wrapper',
            html: '<div style="display:flex; flex-direction:column; align-items:center; cursor:pointer; filter:drop-shadow(0 4px 10px rgba(0,0,0,0.35));">' +
                  '  <div style="width:36px; height:36px; border-radius:50% 50% 50% 0; background:linear-gradient(135deg, ' + c + ', #0f172a); transform:rotate(-45deg); border:2.5px solid #ffffff; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 6px rgba(0,0,0,0.2);">' +
                  '    <i class="fa-solid fa-church" style="color:#ffffff; font-size:14px; transform:rotate(45deg);"></i>' +
                  '  </div>' +
                  '  <div style="background:rgba(15, 23, 42, 0.88); backdrop-filter:blur(4px); color:#ffffff; font-weight:700; font-size:9.5px; padding:2px 7px; border-radius:12px; margin-top:3px; white-space:nowrap; border:1px solid rgba(255,255,255,0.25); text-shadow:0 1px 2px rgba(0,0,0,0.6); pointer-events:none;">' +
                  shortName +
                  '  </div>' +
                  '</div>',
            iconSize: [40, 56],
            iconAnchor: [20, 36],
            popupAnchor: [0, -36]
        });
    }

    function createPopupContent(p) {
        var badgeColor = p.tipe === 'Stasi' ? '#0d9488' : '#0284c7';
        var badgeBg = p.tipe === 'Stasi' ? '#f0fdfa' : '#f0f9ff';
        var badgeBorder = p.tipe === 'Stasi' ? '#99f6e4' : '#bae6fd';

        var html = '<div style="font-family: inherit; min-width: 230px; max-width: 280px; padding: 2px;">' +
            '<div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-bottom: 6px;">' +
            '    <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; background: ' + badgeBg + '; color: ' + badgeColor + '; border: 1px solid ' + badgeBorder + '; padding: 2px 8px; border-radius: 9999px;">' +
            (p.tipe || 'Kapela') +
            '    </span>' +
            '    <span style="font-size: 10px; color: #94a3b8; font-family: monospace; font-weight: 700;">' +
            (p.kode_stasi_kapela || '') +
            '    </span>' +
            '</div>' +
            '<h4 style="font-size: 13px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0; line-height: 1.35;">' +
            (p.nama_stasi_kapela || 'Stasi / Kapela') +
            '</h4>' +
            '<p style="font-size: 11px; color: #475569; margin: 0 0 6px 0; display: flex; align-items: center; gap: 5px;">' +
            '    <i class="fa-solid fa-shield-halved text-amber-500"></i>' +
            '    <span>Pelindung: <strong>' + (p.pelindung && p.pelindung !== '-' ? p.pelindung : 'Belum tercatat') + '</strong></span>' +
            '</p>';

        if (p.alamat && p.alamat !== '-') {
            html += '<p style="font-size: 10.5px; color: #64748b; margin: 0 0 8px 0; line-height: 1.3;">' +
                '<i class="fa-solid fa-location-dot text-rose-500" style="margin-right: 4px;"></i> ' + p.alamat +
                '</p>';
        }

        html += '<div style="display: flex; gap: 6px; padding-top: 8px; border-top: 1px solid #f1f5f9; margin-top: 6px;">';
        if (p.detail_url) {
            html += '<a href="' + p.detail_url + '" style="flex: 1; text-align: center; background: linear-gradient(135deg, #0284c7, #0369a1); color: #ffffff; font-size: 11px; font-weight: 700; padding: 6px 12px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 5px; box-shadow: 0 2px 4px rgba(2,132,199,0.25);">' +
                '<i class="fa-solid fa-circle-info"></i> Buka Profil' +
                '</a>';
        }
        if (p.maps_url) {
            html += '<a href="' + p.maps_url + '" target="_blank" rel="noopener noreferrer" style="background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; font-size: 11px; font-weight: 700; padding: 6px 10px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;" title="Buka di Google Maps">' +
                '<i class="fa-solid fa-arrow-up-right-from-square"></i>' +
                '</a>';
        }
        html += '</div></div>';
        return html;
    }

    fetch('/api/kapela-geojson')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data && data.features && data.features.length > 0) {
                var layer = L.geoJSON(data, {
                    pointToLayer: function(feature, latlng) {
                        var p = feature.properties || {};
                        var icon = createChurchIcon(p.warna_area, p.nama_stasi_kapela);
                        return L.marker(latlng, { icon: icon });
                    },
                    style: function(feature) {
                        var p = feature.properties || {};
                        var color = p.warna_area || '#0284c7';
                        return {
                            color: color,
                            weight: 2.5,
                            opacity: 0.85,
                            fillColor: color,
                            fillOpacity: 0.25,
                            dashArray: '4, 4'
                        };
                    },
                    onEachFeature: function(feature, itemLayer) {
                        var p = feature.properties || {};
                        itemLayer.bindPopup(createPopupContent(p));
                    }
                }).addTo(map);

                if (layer.getBounds().isValid()) {
                    map.fitBounds(layer.getBounds(), { padding: [50, 50] });
                }
            } else {
                var defaultIcon = createChurchIcon('#0284c7', 'Gereja Paroki');
                L.marker(defaultCenter, { icon: defaultIcon })
                    .addTo(map)
                    .bindPopup('<strong>Gereja Paroki Benlutu</strong><br>Pusat Paroki Santo Vinsensius a Paulo')
                    .openPopup();
            }
        })
        .catch(function() {
            var fallbackIcon = createChurchIcon('#0284c7', 'Gereja Paroki');
            L.marker(defaultCenter, { icon: fallbackIcon })
                .addTo(map)
                .bindPopup('<strong>Gereja Paroki Benlutu</strong><br>Pusat Paroki Santo Vinsensius a Paulo')
                .openPopup();
        });
});
