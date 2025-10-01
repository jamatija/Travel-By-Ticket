(function($) {
    'use strict';
    
    let citiesData = null;
    
    async function loadCities() {
        if (citiesData) {
            return citiesData;
        }
        
        try {
            const response = await fetch(busSearchConfig.apiUrl + busSearchConfig.lang, {
                headers: {
                    'X-WP-Nonce': busSearchConfig.nonce
                }
            });
            
            const data = await response.json();
            
            // Proveri format
            if (Array.isArray(data)) {
                citiesData = data;
            } else if (data && Array.isArray(data.results)) {
                citiesData = data.results;
            } else if (data && typeof data === 'object') {
                citiesData = Object.values(data);
            } else {
                citiesData = [];
            }
            
            console.log('✅ Loaded ' + citiesData.length + ' cities');
            console.log('Sample city:', citiesData[0]); // Debug
            return citiesData;
            
        } catch (error) {
            console.error('❌ Error loading cities:', error);
            return [];
        }
    }
    
    $(document).ready(async function() {
        console.log('🚀 Initializing bus search form...');
        
        // Loading state
        $('#from-city, #to-city')
            .html('<option value="">Učitavam...</option>')
            .prop('disabled', true);
        
        // Učitaj gradove
        const cities = await loadCities();
        
        if (cities.length === 0) {
            console.error('❌ No cities loaded!');
            $('#from-city, #to-city')
                .html('<option value="">Greška pri učitavanju</option>')
                .prop('disabled', false);
            return;
        }
        
        // Pripremi opcije - prilagođeno za BusTicket API format
        const options = cities
            .filter(city => {
                // Filtriraj gradove koji nemaju potrebne podatke
                const hasLabel = city.city_label || city.city_primary_name || city.name;
                if (!hasLabel) {
                    console.warn('⚠️ City without label:', city);
                }
                return hasLabel;
            })
            .map(city => {
                // Mapiranje prema API strukturi
                const cityId = city.city_id || city.id;
                const cityLabel = city.city_label || city.city_primary_name || city.name;
                const stateName = city.state_name || city.city_state || '';
                
                // Formatiranje prikaza: "AACHEN (Njemačka)"
                const displayText = stateName 
                    ? `${cityLabel} (${stateName})`
                    : cityLabel;
                
                return {
                    id: String(cityId),
                    text: String(displayText),
                    // Dodatni podaci za kasnije korišćenje
                    cityData: {
                        cityId: cityId,
                        label: cityLabel,
                        primaryName: city.city_primary_name,
                        state: city.city_state,
                        stateName: stateName,
                        stateCode: city.state_code,
                        stateId: city.state_id
                    }
                };
            });
        
        console.log('✅ Prepared ' + options.length + ' options for Select2');
        console.log('First 3 options:', options.slice(0, 3));
        
        // Inicijalizuj Select2
        $('#from-city, #to-city').each(function() {
            const $select = $(this);
            const fieldName = $select.attr('id');
            
            try {
                $select
                    .empty()
                    .prop('disabled', false)
                    .select2({
                        data: options,
                        placeholder: 'Izaberite grad',
                        allowClear: true,
                        width: '100%',
                        minimumInputLength: 2, // Traži bar 2 karaktera
                        language: {
                            noResults: function() {
                                return 'Nema rezultata';
                            },
                            searching: function() {
                                return 'Pretražujem...';
                            },
                            inputTooShort: function() {
                                return 'Unesite najmanje 2 karaktera';
                            }
                        },
                        templateResult: function(data) {
                            if (!data.id) {
                                return data.text;
                            }
                            
                            // Formatiranje rezultata sa bold gradom
                            const parts = data.text.split('(');
                            if (parts.length > 1) {
                                return $('<span><strong>' + parts[0].trim() + '</strong> <small>(' + parts[1] + '</small></span>');
                            }
                            return data.text;
                        },
                        templateSelection: function(data) {
                            return data.text;
                        },
                        matcher: function(params, data) {
                            // Custom matcher za bolju pretragu
                            if ($.trim(params.term) === '') {
                                return data;
                            }
                            
                            if (typeof data.text === 'undefined') {
                                return null;
                            }
                            
                            const term = params.term.toLowerCase();
                            const text = data.text.toLowerCase();
                            
                            // Pretraži po nazivu grada ili državi
                            if (text.indexOf(term) > -1) {
                                return data;
                            }
                            
                            return null;
                        }
                    });
                
                console.log('✅ Select2 initialized for:', fieldName);
                
            } catch (error) {
                console.error('❌ Error initializing Select2 for ' + fieldName + ':', error);
            }
        });
        
        console.log('✅ All Select2 fields initialized successfully!');
        
        // Event listener za submit forme
        $('.bus-form').on('submit', function(e) {
            const fromCity = $('#from-city').select2('data')[0];
            const toCity = $('#to-city').select2('data')[0];
            
            console.log('Form submitted:', {
                from: fromCity,
                to: toCity
            });
            
            // Možeš dodati validaciju ovde
        });
    });
    
})(jQuery);