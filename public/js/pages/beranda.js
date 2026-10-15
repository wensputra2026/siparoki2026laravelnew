document.addEventListener("DOMContentLoaded", function() {
    var typingText = document.querySelector('.hero-typing-text');
    if (typingText) {
        var fullText = typingText.getAttribute('data-typing-text') || typingText.textContent || '';
        var index = 0;
        typingText.textContent = '';
        function typeNextChar() {
            typingText.textContent = fullText.slice(0, index);
            index += 1;
            if (index <= fullText.length) setTimeout(typeNextChar, 45);
        }
        setTimeout(typeNextChar, 500);
    }

    // Autoplay trigger & keepalive for background YouTube iframe
    var ytIframe = document.querySelector('.hero-youtube-iframe');
    if (ytIframe) {
        function triggerYtPlay() {
            if (ytIframe && ytIframe.contentWindow) {
                try {
                    ytIframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
                } catch (e) {}
            }
        }
        ytIframe.addEventListener('load', function() {
            triggerYtPlay();
            setTimeout(triggerYtPlay, 800);
            setTimeout(triggerYtPlay, 2000);
        });
        ['click', 'touchstart', 'scroll'].forEach(function(evt) {
            window.addEventListener(evt, triggerYtPlay, { once: true, passive: true });
        });
    }

    if (document.getElementById('home-map-kapela') && window.L) {
        var defaultCenter = [-9.8541, 124.2872];
        var homeMap = L.map('home-map-kapela', {
            center: defaultCenter,
            zoom: 12,
            scrollWheelZoom: false
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(homeMap);
        homeMap.attributionControl.setPrefix('SIPAROKI');

        function createChurchIcon(color, name) {
            var c = color || '#0284c7';
            var shortName = (name || '').replace(/^(Santo|Santa|Stu\.|St\.)\s*/i, '').trim();
            if (!shortName) shortName = name || 'Gereja';
            if (shortName.length > 18) shortName = shortName.slice(0, 16) + '...';

            return L.divIcon({
                className: 'church-pin-wrapper',
                html: '<div style="display:flex; flex-direction:column; align-items:center; cursor:pointer; filter:drop-shadow(0 4px 8px rgba(0,0,0,0.3));">' +
                      '  <div style="width:32px; height:32px; border-radius:50% 50% 50% 0; background:linear-gradient(135deg, ' + c + ', #0f172a); transform:rotate(-45deg); border:2px solid #ffffff; display:flex; align-items:center; justify-content:center;">' +
                      '    <i class="fa-solid fa-church" style="color:#ffffff; font-size:12px; transform:rotate(45deg);"></i>' +
                      '  </div>' +
                      '  <div style="background:rgba(15, 23, 42, 0.88); backdrop-filter:blur(4px); color:#ffffff; font-weight:700; font-size:9px; padding:2px 6px; border-radius:10px; margin-top:2px; white-space:nowrap; border:1px solid rgba(255,255,255,0.25);">' +
                      shortName +
                      '  </div>' +
                      '</div>',
                iconSize: [36, 50],
                iconAnchor: [18, 32],
                popupAnchor: [0, -32]
            });
        }

        function createPopupContent(p) {
            var html = '<div style="font-family: inherit; min-width: 220px; padding: 2px;">' +
                '<div style="font-size: 10px; font-weight: 800; color: #0284c7; text-transform: uppercase; margin-bottom: 3px;">' + (p.tipe || 'Kapela') + '</div>' +
                '<h4 style="font-size: 13px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">' + (p.nama_stasi_kapela || 'Stasi / Kapela') + '</h4>' +
                '<p style="font-size: 11px; color: #475569; margin: 0 0 6px 0;">Pelindung: <strong>' + (p.pelindung && p.pelindung !== '-' ? p.pelindung : 'Belum tercatat') + '</strong></p>';
            if (p.detail_url) {
                html += '<a href="' + p.detail_url + '" style="display: inline-flex; align-items: center; gap: 4px; background: #0284c7; color: #ffffff; font-size: 10.5px; font-weight: 700; padding: 5px 10px; border-radius: 6px; text-decoration: none; margin-top: 4px;">Lihat Profil &rarr;</a>';
            }
            html += '</div>';
            return html;
        }

        fetch('/api/kapela-geojson')
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.features && data.features.length > 0) {
                    var geoLayer = L.geoJSON(data, {
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
                                weight: 2,
                                opacity: 0.8,
                                fillColor: color,
                                fillOpacity: 0.2,
                                dashArray: '4, 4'
                            };
                        },
                        onEachFeature: function(feature, layer) {
                            var p = feature.properties || {};
                            layer.bindPopup(createPopupContent(p));
                        }
                    }).addTo(homeMap);
                    var bounds = geoLayer.getBounds();
                    if (bounds.isValid()) homeMap.fitBounds(bounds, { padding: [30, 30] });
                } else {
                    var defaultIcon = createChurchIcon('#0284c7', 'Gereja Paroki');
                    L.marker(defaultCenter, { icon: defaultIcon }).addTo(homeMap)
                        .bindPopup('<strong>Gereja Paroki Benlutu</strong><br>Santo Vinsensius a Paulo')
                        .openPopup();
                }
                setTimeout(function() { homeMap.invalidateSize(); }, 300);
            })
            .catch(function() {
                var defaultIcon = createChurchIcon('#0284c7', 'Gereja Paroki');
                L.marker(defaultCenter, { icon: defaultIcon }).addTo(homeMap)
                    .bindPopup('<strong>Gereja Paroki Benlutu</strong><br>Santo Vinsensius a Paulo');
                setTimeout(function() { homeMap.invalidateSize(); }, 300);
            });
    }

    // Inisialisasi Swiper Slider Pelayan Pastoral
    function initPelayanSwiper() {
        var sliderEl = document.querySelector('.swiper-pelayan-pastoral');
        if (!sliderEl) return;
        if (typeof Swiper === 'undefined') {
            setTimeout(initPelayanSwiper, 150);
            return;
        }
        var slides = sliderEl.querySelectorAll('.swiper-slide');
        var slideCount = slides.length;
        if (slideCount === 0) return;

        new Swiper('.swiper-pelayan-pastoral', {
            slidesPerView: 1,
            spaceBetween: 20,
            speed: 600,
            grabCursor: true,
            loop: slideCount > 3,
            autoplay: slideCount > 1 ? {
                delay: 4500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            pagination: {
                el: '.swiper-pagination-pelayan',
                clickable: true,
                dynamicBullets: slideCount > 4,
            },
            navigation: {
                prevEl: '.pelayan-slider-prev',
                nextEl: '.pelayan-slider-next',
            },
            breakpoints: {
                640: {
                    slidesPerView: Math.min(slideCount, 2),
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: Math.min(slideCount, 3),
                    spaceBetween: 28,
                }
            }
        });
    }
    initPelayanSwiper();
});

