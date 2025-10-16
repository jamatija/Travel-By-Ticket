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
            
            if (Array.isArray(data)) {
                citiesData = data;
            } else if (data && Array.isArray(data.results)) {
                citiesData = data.results;
            } else if (data && typeof data === 'object') {
                citiesData = Object.values(data);
            } else {
                citiesData = [];
            }
            
            return citiesData;
            
        } catch (error) {
            console.error('❌ Error loading cities:', error);
            return [];
        }
    }
    
    function formatDate(dateString) {
        if (!dateString) return '';
        
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        
        return `${day}-${month}-${year}`;
    }
    
    function cleanCityName(cityName) {
        if (!cityName) return '';
        
        return cityName
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]/g, '')
            .replace(/\-+/g, '-')
            .replace(/^\-+|\-+$/g, '');
    }
    
    function buildBusTicketUrl(formData) {
        const baseUrl = 'https://busticket4.me';
        const lang = busSearchConfig.lang || 'MNE';
        
        const fromStationId = formData.fromCityId;
        const toStationId = formData.toCityId;
        const cassiopeiaId = '132';
        const affiliateId = '0';
        const zero = '0';
        
        const stationPart = `${fromStationId}-${toStationId}-${cassiopeiaId}-${affiliateId}-${zero}`;
        
        const hasReturnDate = formData.returnDate && formData.returnDate.trim() !== '';
        const isRoundTrip = hasReturnDate ? '1' : '0';
        const passengers = formData.passengers || '1';
        
        const tripPart = `${isRoundTrip}-${passengers}`;
        
        
        const fromCityName = cleanCityName(formData.fromCityLabel);
        const toCityName = cleanCityName(formData.toCityLabel);
        const routePart = `${fromCityName}-${toCityName}`;
        
        const departDate = formatDate(formData.departDate);
        
        let url = `${baseUrl}/${lang}/${stationPart}/${tripPart}/${routePart}/${departDate}/`;
        
        if (hasReturnDate) {
            const returnDate = formatDate(formData.returnDate);
            url += `${returnDate}/`;
        }
        
        return url;
    }
    
    $(document).ready(async function() {

        // Postavi početne placeholdere
        $('#from-city').html('<option value="">Mjesto polaska</option>').prop('disabled', true);
        $('#to-city').html('<option value="">Odredište</option>').prop('disabled', true);
        
        const cities = await loadCities();
        
        if (cities.length === 0) {
            $('#from-city, #to-city')
                .html('<option value="">Greška pri učitavanju</option>')
                .prop('disabled', false);
            return;
        }
        
        const options = cities
            .filter(city => {
                const hasLabel = city.city_label || city.city_primary_name;
                if (!hasLabel) {
                    console.warn('⚠️ City without label:', city);
                }
                return hasLabel;
            })
            .map(city => {
                const cityId = city.city_id || city.id;
                const cityLabel = city.city_label || city.city_primary_name;
                const stateName = city.state_name || city.city_state || '';
                
                const displayText = stateName 
                    ? `${cityLabel} (${stateName})`
                    : cityLabel;
                
                return {
                    id: String(cityId),
                    text: String(displayText),
                    cityLabel: cityLabel.trim(),
                    stateName: stateName,
                    cityData: city
                };
            });
        
        // Inicijalizuj Select2 sa različitim placeholderima
        $('#from-city, #to-city').each(function() {
            const $select = $(this);
            const fieldId = $select.attr('id');
            
            // Različiti placeholderi
            const placeholder = fieldId === 'from-city' 
                ? 'Mjesto polaska' 
                : 'Odredište';
            
            try {
                // Dodaj praznu opciju kao prvu
                $select.empty();
                $select.append('<option value=""></option>'); // Prazna opcija za placeholder
                
                $select
                    .prop('disabled', false)
                    .select2({
                        data: options,
                        placeholder: placeholder,
                        allowClear: true,
                        width: '100%',
                        minimumInputLength: 2,
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
                            
                            const parts = data.text.split('(');
                            if (parts.length > 1) {
                                return $('<span><strong>' + parts[0].trim() + '</strong> <small>(' + parts[1] + '</small></span>');
                            }
                            return data.text;
                        },
                        templateSelection: function(data) {
                            // Ako je prazna opcija, prikaži placeholder
                            if (!data.id) {
                                return placeholder;
                            }
                            return data.text;
                        }
                    });
                
                // Eksplicitno postavi da nema selekcije
                $select.val(null).trigger('change');
                
                
            } catch (error) {
                console.error('❌ Error initializing Select2:', error);
            }
        });
        
        
        // Inicijalizuj Flatpickr za datume
        const departDatePicker = flatpickr("#depart-date", {
            altInput: true,
            altFormat: "d.m.Y", 
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: new Date(),
            disableMobile: true,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Ned', 'Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub'],
                    longhand: ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
                    longhand: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar']
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                // Kada se promeni datum polaska, ažuriraj minimum za povratak
                if (selectedDates.length > 0) {
                    returnDatePicker.set('minDate', selectedDates[0]);
                }
            }
        });
        
        const returnDatePicker = flatpickr("#return-date", {
            altInput: true,
            altFormat: "d.m.Y", 
            dateFormat: "Y-m-d",
            minDate: "today",
            disableMobile: true,
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Ned', 'Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub'],
                    longhand: ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota']
                },
                months: {
                    shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
                    longhand: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar']
                }
            }
        });
        
        $('.bus-form').on('submit', function(e) {
            e.preventDefault();
            
            const fromCity = $('#from-city').select2('data')[0];
            const toCity = $('#to-city').select2('data')[0];
            const departDate = $('#depart-date').val();
            const returnDate = $('#return-date').val();
            const passengers = $('#passengers').val();
            
            if (!fromCity || !fromCity.id) {
                alert('Molimo izaberite grad polaska!');
                return false;
            }
            
            if (!toCity || !toCity.id) {
                alert('Molimo izaberite grad odredišta!');
                return false;
            }
            
            if (!departDate) {
                alert('Molimo unesite datum polaska!');
                return false;
            }
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const selectedDate = new Date(departDate);
            
            if (selectedDate < today) {
                alert('Datum polaska mora biti danas ili u budućnosti!');
                return false;
            }
            
            if (returnDate && returnDate.trim() !== '') {
                const returnDateObj = new Date(returnDate);
                if (returnDateObj < selectedDate) {
                    alert('Datum povratka mora biti nakon datuma polaska!');
                    return false;
                }
            }
            
            const formData = {
                fromCityId: fromCity.id,
                fromCityLabel: fromCity.cityLabel,
                toCityId: toCity.id,
                toCityLabel: toCity.cityLabel,
                departDate: departDate,
                returnDate: returnDate && returnDate.trim() !== '' ? returnDate : null,
                passengers: passengers
            };
            
            const busTicketUrl = buildBusTicketUrl(formData);
            
            window.open(busTicketUrl, '_blank');
            
            return false;
        });
    });
})(jQuery);