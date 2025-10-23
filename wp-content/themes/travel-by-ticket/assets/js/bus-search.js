(function($) {
    'use strict';
    
    // Cache config
    const CACHE_KEY = 'bus_cities_cache';
    const CACHE_VERSION = 'v1';
    const CACHE_DURATION = 24 * 60 * 60 * 1000;
    
    let citiesCache = {
        MNE: null,
        EN: null
    };
    
    // Translations
    const translations = {
        'en-US': {
            fromPlaceholder: 'Departure city',
            toPlaceholder: 'Destination',
            loadError: 'Loading error',
            noResults: 'No results found',
            searching: 'Searching...',
            startTyping: 'Start typing to search...',
            selectDepartureCity: 'Please select departure city!',
            selectDestinationCity: 'Please select destination city!',
            enterDepartureDate: 'Please enter departure date!',
            futureDateRequired: 'Departure date must be today or in the future!',
            returnAfterDeparture: 'Return date must be after departure date!',
            weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            weekdaysLong: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            monthsLong: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        },
        'default': {
            fromPlaceholder: 'Mjesto polaska',
            toPlaceholder: 'Odredište',
            loadError: 'Greška pri učitavanju',
            noResults: 'Nema rezultata',
            searching: 'Pretražujem...',
            startTyping: 'Počnite kucati za pretragu...',
            selectDepartureCity: 'Molimo izaberite grad polaska!',
            selectDestinationCity: 'Molimo izaberite grad odredišta!',
            enterDepartureDate: 'Molimo unesite datum polaska!',
            futureDateRequired: 'Datum polaska mora biti danas ili u budućnosti!',
            returnAfterDeparture: 'Datum povratka mora biti nakon datuma polaska!',
            weekdaysShort: ['Ned', 'Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub'],
            weekdaysLong: ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
            monthsLong: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar']
        }
    };
    
    function getCurrentLanguage() {
        const htmlLang = document.documentElement.lang;
        console.log('🌐 Detected HTML lang:', htmlLang);
        
        // Proveri da li je engleski (bilo koji varijanta)
        if (htmlLang && htmlLang.toLowerCase().startsWith('en')) {
            console.log('📝 Using translation set: en-US');
            return 'en-US';
        }
        
        // Sve ostalo je default (crnogorski/srpski/bosanski)
        console.log('📝 Using translation set: default');
        return 'default';
    }
    
    function getApiLanguage() {
        const htmlLang = document.documentElement.lang;
        console.log('🌐 API Language detection for:', htmlLang);
        
        // Proveri da li je engleski
        if (htmlLang && htmlLang.toLowerCase().startsWith('en')) {
            console.log('📡 Using API lang: EN');
            return 'EN';
        }
        
        // Sve ostalo koristi MNE API
        console.log('📡 Using API lang: MNE');
        return 'MNE';
    }
    
    function getTranslation(key) {
        const lang = getCurrentLanguage();
        return translations[lang][key];
    }
    
    function saveToLocalStorage(data) {
        try {
            const cacheData = {
                version: CACHE_VERSION,
                timestamp: Date.now(),
                data: data
            };
            localStorage.setItem(CACHE_KEY, JSON.stringify(cacheData));
        } catch (error) {
            console.warn('⚠️ Could not save to localStorage:', error);
        }
    }
    
    function loadFromLocalStorage() {
        try {
            const cached = localStorage.getItem(CACHE_KEY);
            if (!cached) return null;
            
            const cacheData = JSON.parse(cached);
            
            if (cacheData.version !== CACHE_VERSION) {
                localStorage.removeItem(CACHE_KEY);
                return null;
            }
            
            const age = Date.now() - cacheData.timestamp;
            if (age > CACHE_DURATION) {
                localStorage.removeItem(CACHE_KEY);
                return null;
            }
            
            return cacheData.data;
        } catch (error) {
            console.warn('⚠️ Could not load from localStorage:', error);
            return null;
        }
    }
    
    async function loadAllCities() {
        const cachedData = loadFromLocalStorage();
        if (cachedData && cachedData.MNE && cachedData.EN) {
            citiesCache = cachedData;
            return true;
        }
        
        try {
            const [mneResponse, enResponse] = await Promise.all([
                fetch(busSearchConfig.apiUrl + 'MNE', {
                    headers: { 'X-WP-Nonce': busSearchConfig.nonce }
                }),
                fetch(busSearchConfig.apiUrl + 'EN', {
                    headers: { 'X-WP-Nonce': busSearchConfig.nonce }
                })
            ]);
            
            const [mneData, enData] = await Promise.all([
                mneResponse.json(),
                enResponse.json()
            ]);
            
            citiesCache.MNE = normalizeData(mneData);
            citiesCache.EN = normalizeData(enData);
            
            saveToLocalStorage(citiesCache);
            return true;
        } catch (error) {
            console.error('❌ Error loading cities:', error);
            return false;
        }
    }
    
    function normalizeData(data) {
        if (Array.isArray(data)) {
            return data;
        } else if (data && Array.isArray(data.results)) {
            return data.results;
        } else if (data && typeof data === 'object') {
            return Object.values(data);
        }
        return [];
    }
    
    function getCurrentCities() {
        const lang = getApiLanguage();
        return citiesCache[lang] || [];
    }
    
    // Normalizacija teksta (uklanja dijakritike)
    function normalizeText(text) {
        if (!text) return '';
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd')
            .replace(/Đ/g, 'd');
    }
    
    // AUTOCOMPLETE FUNKCIONALNOST
    class CityAutocomplete {
        constructor(inputElement, hiddenInputElement) {
            this.$input = $(inputElement);
            this.$hidden = $(hiddenInputElement);
            this.$dropdown = null;
            this.selectedCity = null;
            this.init();
        }
        
        init() {
            this.$dropdown = $('<div class="city-autocomplete-dropdown"></div>');
            this.$input.after(this.$dropdown);
            
            this.$input.on('input', (e) => this.handleInput(e));
            this.$input.on('focus', (e) => this.handleFocus(e));
            
            $(document).on('click', (e) => {
                if (!$(e.target).closest('.form-field').length) {
                    this.hideDropdown();
                }
            });
        }
        
        handleInput(e) {
            const query = this.$input.val().trim();
            
            if (query.length < 2) {
                this.hideDropdown();
                this.clearSelection();
                return;
            }
            
            this.search(query);
        }
        
        handleFocus(e) {
            const query = this.$input.val().trim();
            if (query.length >= 2) {
                this.search(query);
            }
        }
        
        search(query) {
            const cities = getCurrentCities();
            const normalizedQuery = normalizeText(query);
            
            const results = cities
                .filter(city => {
                    const cityLabel = city.city_label || city.city_primary_name || '';
                    const stateName = city.state_name || city.city_state || '';
                    
                    const normalizedCity = normalizeText(cityLabel);
                    const normalizedState = normalizeText(stateName);
                    
                    return normalizedCity.includes(normalizedQuery) || 
                           normalizedState.includes(normalizedQuery);
                })
                .slice(0, 10);
            
            this.showResults(results, query);
        }
        
        showResults(results, query) {
            if (results.length === 0) {
                this.$dropdown.html(`<div class="autocomplete-item no-results">${getTranslation('noResults')}</div>`);
                this.$dropdown.addClass('active');
                return;
            }
            
            const html = results.map(city => {
                const cityId = city.city_id || city.id;
                const cityLabel = city.city_label || city.city_primary_name;
                const stateName = city.state_name || city.city_state || '';
                
                const displayText = stateName 
                    ? `${cityLabel} <span class="state">(${stateName})</span>`
                    : cityLabel;
                
                return `<div class="autocomplete-item" data-city-id="${cityId}" data-city-label="${cityLabel}">
                    ${displayText}
                </div>`;
            }).join('');
            
            this.$dropdown.html(html);
            this.$dropdown.addClass('active');
            
            this.$dropdown.find('.autocomplete-item').not('.no-results').on('click', (e) => {
                const $item = $(e.currentTarget);
                this.selectCity({
                    id: $item.data('city-id'),
                    label: $item.data('city-label')
                });
            });
        }
        
        selectCity(city) {
            this.selectedCity = city;
            this.$input.val(city.label);
            this.$hidden.val(city.id);
            this.hideDropdown();
        }
        
        clearSelection() {
            this.selectedCity = null;
            this.$hidden.val('');
        }
        
        hideDropdown() {
            this.$dropdown.removeClass('active');
        }
        
        showDropdown() {
            this.$dropdown.addClass('active');
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
        const lang = getApiLanguage();
        
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
        const loaded = await loadAllCities();
        
        if (!loaded || getCurrentCities().length === 0) {
            alert(getTranslation('loadError'));
            return;
        }
        
        const fromAutocomplete = new CityAutocomplete('#from-city', '#from-city-id');
        const toAutocomplete = new CityAutocomplete('#to-city', '#to-city-id');
        
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
                    shorthand: getTranslation('weekdaysShort'),
                    longhand: getTranslation('weekdaysLong')
                },
                months: {
                    shorthand: getTranslation('monthsShort'),
                    longhand: getTranslation('monthsLong')
                }
            },
            onChange: function(selectedDates) {
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
                    shorthand: getTranslation('weekdaysShort'),
                    longhand: getTranslation('weekdaysLong')
                },
                months: {
                    shorthand: getTranslation('monthsShort'),
                    longhand: getTranslation('monthsLong')
                }
            }
        });
        
        $('.bus-form').on('submit', function(e) {
            e.preventDefault();
            
            const fromCityId = $('#from-city-id').val();
            const fromCityLabel = $('#from-city').val();
            const toCityId = $('#to-city-id').val();
            const toCityLabel = $('#to-city').val();
            const departDate = $('#depart-date').val();
            const returnDate = $('#return-date').val();
            const passengers = $('#passengers').val();
            
            if (!fromCityId) {
                alert(getTranslation('selectDepartureCity'));
                return false;
            }
            
            if (!toCityId) {
                alert(getTranslation('selectDestinationCity'));
                return false;
            }
            
            if (!departDate) {
                alert(getTranslation('enterDepartureDate'));
                return false;
            }
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const selectedDate = new Date(departDate);
            
            if (selectedDate < today) {
                alert(getTranslation('futureDateRequired'));
                return false;
            }
            
            if (returnDate && returnDate.trim() !== '') {
                const returnDateObj = new Date(returnDate);
                if (returnDateObj < selectedDate) {
                    alert(getTranslation('returnAfterDeparture'));
                    return false;
                }
            }
            
            const formData = {
                fromCityId: fromCityId,
                fromCityLabel: fromCityLabel,
                toCityId: toCityId,
                toCityLabel: toCityLabel,
                departDate: departDate,
                returnDate: returnDate && returnDate.trim() !== '' ? returnDate : null,
                passengers: passengers
            };
            
            const busTicketUrl = buildBusTicketUrl(formData);
            window.open(busTicketUrl, '_blank');
            
            return false;
        });
    });
    
    window.clearBusCitiesCache = function() {
        localStorage.removeItem(CACHE_KEY);
        console.log('Bus cities cache cleared!');
    };
})(jQuery);