<?php

use Mailjet\Resources;

function dot_subscribe_contact_to_mailet()
{

    if (!wp_doing_ajax()) {
        return;
    }

    if (!acf_maybe_get($_ENV, 'MJ_APIKEY_PUBLIC') || !acf_maybe_get($_ENV, 'MJ_APIKEY_PRIVATE')) {
        wp_send_json_error(
            array(
                "error" => "Clés d'API Mailjet introuvables. Veuillez vérifiez votre fichier d'environnement"
            )
        );
    }

    if (!isset($_POST['data'])) {
        wp_send_json_error(
            array(
                'error' => 'Données manquantes pour l\'inscription.'
            )
        );
        wp_die();
    }

    $decoded_data = json_decode(wp_unslash($_POST['data']), true);

    if (JSON_ERROR_NONE !== json_last_error() || !is_array($decoded_data)) {
        wp_send_json_error(
            array(
                'error' => 'Format de données invalide.'
            )
        );
        wp_die();
    }

    $email = isset($decoded_data['email']) ? sanitize_email($decoded_data['email']) : '';
    $lastname = isset($decoded_data['lastname']) ? sanitize_text_field($decoded_data['lastname']) : '';
    $firstname = isset($decoded_data['firstname']) ? sanitize_text_field($decoded_data['firstname']) : '';
    $company = isset($decoded_data['company']) ? sanitize_text_field($decoded_data['company']) : '';
    $role = isset($decoded_data['role']) ? sanitize_text_field($decoded_data['role']) : '';
    $city = isset($decoded_data['city']) ? sanitize_text_field($decoded_data['city']) : '';

    $required_fields = array(
        'Adresse e-mail' => $email,
        'Nom de famille' => $lastname,
        'Prénom' => $firstname,
        'Entreprise' => $company,
        'Ville' => $city,
    );

    foreach ($required_fields as $label => $value) {
        if (empty($value)) {
            wp_send_json_error(
                array(
                    'error' => sprintf('%s est obligatoire.', $label)
                )
            );
            wp_die();
        }
    }

    if (!is_email($email)) {
        wp_send_json_error(
            array(
                'error' => 'Adresse e-mail invalide.'
            )
        );
        wp_die();
    }

    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3']);

    /**
     * Create a Mailjet contact
     *
     * @param [type] $mj
     * @param [type] $email
     * @return \Mailjet\Response
     */
    function create_contact($mj, $email)
    {
        $body = [
            'IsExcludedFromCampaigns' => "false",
            'Email' => $email
        ];
        return $mj->post(Resources::$Contact, ['body' => $body]);
    }

    /**
     * Add custom properties to a Mailjet contact
     *
     * @param [type] $mj
     * @param [type] $id
     * @param [type] $lastname
     * @param [type] $firstname
     * @param [type] $country
     * @param [type] $zipcode
     * @param [type] $business
     * @return \Mailjet\Response
     */
    function add_contact_properties($mj, $id, $params)
    {
        $properties = [
            'lastname' => $params['lastname'],
            'firstname' => $params['firstname'],
            'company' => $params['company'],
            'city' => $params['city'],
        ];

        if (!empty($params['role'])) {
            $properties['role'] = $params['role'];
        }

        static $known_property_names = null;

        if (!is_array($known_property_names)) {
            $metadata_response = $mj->get(Resources::$Contactmetadata);

            if ($metadata_response->success()) {
                $known_property_names = array_map(
                    function ($property) {
                        return isset($property['Name']) ? strtolower($property['Name']) : null;
                    },
                    $metadata_response->getData()
                );
                $known_property_names = array_filter($known_property_names);
            } else {
                $known_property_names = [];
            }
        }

        if (!empty($known_property_names)) {
            foreach ($properties as $name => $value) {
                if (!in_array(strtolower($name), $known_property_names, true)) {
                    unset($properties[$name]);
                }
            }
        }

        $properties = array_filter(
            $properties,
            function ($value) {
                return !empty($value);
            }
        );

        if (empty($properties)) {
            return true;
        }

        $body = [
            'Data' => []
        ];

        foreach ($properties as $name => $value) {
            $body['Data'][] = [
                'Name' => $name,
                'Value' => $value
            ];
        }

        $response = $mj->put(Resources::$Contactdata, ['id' => $id, 'body' => $body]);

        if ($response->success()) {
            return $response;
        }

        $response_data = $response->getData();
        $error_details = $response_data[0] ?? [];
        $error_message = isset($error_details['ErrorMessage']) ? $error_details['ErrorMessage'] : '';

        if ($error_message && stripos($error_message, 'Invalid key name') !== false) {
            if (preg_match('/Invalid key name:\s*["\']?([a-z0-9_\-]+)["\']?/i', $error_message, $matches)) {
                $invalid_property = $matches[1];
                unset($properties[$invalid_property]);

                $properties = array_filter(
                    $properties,
                    function ($value) {
                        return !empty($value);
                    }
                );

                if (empty($properties)) {
                    return true;
                }

                $retry_body = [
                    'Data' => []
                ];

                foreach ($properties as $name => $value) {
                    $retry_body['Data'][] = [
                        'Name' => $name,
                        'Value' => $value
                    ];
                }

                $retry_response = $mj->put(Resources::$Contactdata, ['id' => $id, 'body' => $retry_body]);

                return $retry_response;
            }
        }

        return $response;
    }

    /**
     * Add a Mailjet contact to a Mailjet list
     *
     * @param [type] $mj
     * @param [type] $id
     * @return \Mailjet\Response
     */
    function add_contact_to_list($mj, $email)
    {
        $LIST_ID = get_field('newsletter_contact_list_id', 'option');


        $body = [
            'ContactAlt' => $email,
            'ListID' => $LIST_ID,
            'IsUnsubscribed' => "false",
            "IsActive" => true,
        ];
        return $mj->post(Resources::$Listrecipient, ['body' => $body]);
    }

    $params = [
        'email' => $email,
        'lastname' => $lastname,
        'firstname' => $firstname,
        'company' => $company,
        'role' => $role,
        'city' => $city
    ];


    $create_request = create_contact($mj, $email);
    $create_request_data = $create_request->getData();

    if (!$create_request->success()) {
        wp_send_json_error(
            array(
                "failOn" => "create_contact",
                "response" => $create_request_data
            )
        );
    }

    $id = $create_request_data[0]['ID'];

    $add_properties_request = add_contact_properties($mj, $id, $params);

    if ($add_properties_request instanceof \Mailjet\Response && !$add_properties_request->success()) {
        wp_send_json_error(
            array(
                "failOn" => "add_contact_properties",
                "response" => $add_properties_request->getData()
            )
        );
    }

    $add_to_list_request = add_contact_to_list($mj, $email);
    $add_to_list_request_data = $add_to_list_request->getData();

    if (!$add_to_list_request->success()) {
        wp_send_json_error(
            array(
                "failOn" => "add_contact_to_list",
                "response" => get_field('newsletter_contact_list_id', 'option')
            )
        );
    }

    wp_send_json_success();
    wp_die();
}

add_action('wp_ajax_subscribe_contact_to_mailjet', 'dot_subscribe_contact_to_mailet');
add_action('wp_ajax_nopriv_subscribe_contact_to_mailjet', 'dot_subscribe_contact_to_mailet');
