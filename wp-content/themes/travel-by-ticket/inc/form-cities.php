<?php 
add_action('rest_api_init', function () {
    register_rest_route('busticket/v1', '/cities/(?P<lang>[a-zA-Z]+)', array(
        'methods' => 'GET',
        'callback' => 'get_cities_cached',
        'permission_callback' => '__return_true'
    ));
});

function get_cities_cached($request) {
    $lang = $request['lang'];
    $search = $request->get_param('search');
    
    $cache_key = 'bus_cities_' . $lang . '_v3';
    $cache_duration = 24 * HOUR_IN_SECONDS;
    
    // Proveri cache
    $cached = get_transient($cache_key);
    
    if ($cached === false) {
        error_log('BusTicket: Cache MISS for lang: ' . $lang);
        
        // Pozovi eksterni API
        $response = wp_remote_post('https://busticket4.me/bus/web_servisi/servisi/rest_bus_search.php?name=doCitiesSearch', array(
            'body' => array('jezik' => $lang),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            error_log('BusTicket API Error: ' . $response->get_error_message());
            return new WP_Error('api_error', 'Failed to fetch cities', array('status' => 500));
        }
        
        $body = wp_remote_retrieve_body($response);
        $cached = json_decode($body, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('BusTicket JSON Error: ' . json_last_error_msg());
            return new WP_Error('json_error', 'Invalid JSON', array('status' => 500));
        }
        
        if (empty($cached) || !is_array($cached)) {
            error_log('BusTicket: Empty or invalid data received');
            return new WP_Error('no_data', 'No cities available', array('status' => 404));
        }
        
        error_log('BusTicket: Caching ' . count($cached) . ' cities');
        set_transient($cache_key, $cached, $cache_duration);
    } else {
        error_log('BusTicket: Cache HIT - ' . count($cached) . ' cities');
    }
    
    // Filtriraj po search termu (ispravljeno za city_label)
    $filtered = $cached;
    if ($search) {
        $filtered = array_filter($cached, function($city) use ($search) {
            $searchIn = strtolower($city['city_label'] ?? $city['city_primary_name'] ?? '');
            return stripos($searchIn, strtolower($search)) !== false;
        });
        $filtered = array_values($filtered); // Re-index
    }
    
    // UKLONJENA PAGINATION - vrati SVE gradove
    return rest_ensure_response($filtered);
}


function bus_search_form_shortcode() {
    ob_start();
    ?>
    <div class="bus-search-form">
        <form method="GET" action="<?php echo esc_url(home_url('/bus-results')); ?>" class="bus-form">
            <div class="form-row">
                <div class="form-field">
                    <label for="from-city">Polazak iz</label>
                    <select id="from-city" name="from_city" required>
                        <option value="">Učitavam...</option>
                    </select>
                </div>
                
                <div class="form-field">
                    <label for="to-city">Odredište</label>
                    <select id="to-city" name="to_city" required>
                        <option value="">Učitavam...</option>
                    </select>
                </div>
                
                <div class="form-field">
                    <label for="depart-date">Datum polaska</label>
                    <input type="date" id="depart-date" name="depart_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="form-field">
                    <label for="return-date">Datum povratka</label>
                    <input type="date" id="return-date" name="return_date" placeholder="Opciono">
                </div>
                
                <div class="form-field">
                    <label for="passengers">Putnici</label>
                    <input type="number" id="passengers" name="passengers" value="1" min="1" max="9" required>
                </div>
                
                <div class="form-field">
                    <label style="opacity: 0;">Search</label>
                    <button type="submit" class="search-btn">Pretraži</button>
                </div>
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('bus_search_form', 'bus_search_form_shortcode');

// WP-Cron za refresh cache
add_action('wp', 'schedule_cities_cache_refresh');
function schedule_cities_cache_refresh() {
    if (!wp_next_scheduled('refresh_bus_cities_cache')) {
        wp_schedule_event(time(), 'daily', 'refresh_bus_cities_cache');
    }
}

add_action('refresh_bus_cities_cache', 'refresh_cities_cache');
function refresh_cities_cache() {
    $langs = array('MNE', 'EN', 'RU');
    foreach ($langs as $lang) {
        delete_transient('bus_cities_' . $lang . '_v3');
        // Trigger cache rebuild
        wp_remote_get(rest_url('busticket/v1/cities/' . $lang));
    }
}

// Manual cache clear (pristup: /wp-admin/?clear_bus_cache=1)
add_action('admin_init', function() {
    if (isset($_GET['clear_bus_cache']) && current_user_can('manage_options')) {
        delete_transient('bus_cities_MNE_v3');
        delete_transient('bus_cities_EN_v3');
        delete_transient('bus_cities_RU_v3');
        wp_die('✅ Bus cities cache cleared! <br><br><a href="' . admin_url() . '">← Back to Dashboard</a>');
    }
});