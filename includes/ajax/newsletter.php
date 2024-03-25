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

    if (!isset($_POST)) {
        wp_send_json_error('Error : missing POST data');
        wp_die();
    }

    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3']);
    $contact_data = json_decode(stripslashes($_POST['data']));

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
        $body = [
            'Data' => [
                [
                    'Name' => "lastname",
                    'Value' => $params['lastname']
                ],
                [
                    'Name' => "firstname",
                    'Value' => $params['firstname']
                ],
                [
                    'Name' => 'company',
                    'Value' => $params['company']
                ],
                [
                    'Name' => 'city',
                    'Value' => $params['city']
                ]
            ]
        ];

        if ($params['role']) {
            $body['Data'][] = ['Name' => 'role', 'Value' => $params['role']];
        }

        return $mj->put(Resources::$Contactdata, ['id' => $id, 'body' => $body]);
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


    $email = $contact_data->email;
    $params = [
        'email' => $email,
        'lastname' => $contact_data->lastname,
        'firstname' => $contact_data->firstname,
        'company' => $contact_data->company,
        'role' => $contact_data->role,
        'city' => $contact_data->city
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
    $add_properties_request_data = $add_properties_request->getData();

    if (!$add_properties_request->success()) {
        wp_send_json_error(
            array(
                "failOn" => "add_contact_properties",
                "response" => $add_properties_request_data
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
