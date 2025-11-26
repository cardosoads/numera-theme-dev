<?php

if (!defined('ABSPATH')) {
    exit;
}

class Numera_Hotmart_Webhook_Controller
{
    public static function init(): void
    {
        add_action('rest_api_init', [self::class, 'register_routes']);
    }

    public static function register_routes(): void
    {
        register_rest_route(
            'numera/v1',
            '/hotmart-webhook',
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [self::class, 'handle_request'],
                'permission_callback' => '__return_true',
            ]
        );
    }

    public static function handle_request(WP_REST_Request $request)
    {
        $settings = Numera_Hotmart_Settings::get_settings();

        if (empty($settings['enabled'])) {
            return new WP_Error('hotmart_disabled', __('Integração desativada.', 'numera_theme'), ['status' => 403]);
        }

        $expected_token = $settings['secret'];

        if (empty($expected_token)) {
            return new WP_Error('hotmart_missing_secret', __('Token não configurado.', 'numera_theme'), ['status' => 403]);
        }

        $provided_token = $request->get_header('x-hotmart-hottok') ?: $request->get_param('hottok');

        if (!hash_equals($expected_token, (string) $provided_token)) {
            return new WP_Error('hotmart_invalid_token', __('Token inválido.', 'numera_theme'), ['status' => 403]);
        }

        $payload = self::extract_payload($request);

        if (empty($payload)) {
            return new WP_Error('hotmart_empty_payload', __('Payload vazio ou inválido.', 'numera_theme'), ['status' => 400]);
        }

        $event_key = self::normalize_event_key($payload);

        if (!$event_key) {
            return new WP_Error('hotmart_event_not_detected', __('Evento não informado.', 'numera_theme'), ['status' => 422]);
        }

        $result = Numera_Hotmart_Client_Sync::handle_event($event_key, $payload, $settings);

        if (is_wp_error($result)) {
            return $result;
        }

        return $result;
    }

    protected static function extract_payload(WP_REST_Request $request): array
    {
        $json = $request->get_json_params();

        if (!empty($json)) {
            return $json;
        }

        $body = json_decode($request->get_body(), true);

        if (is_array($body)) {
            return $body;
        }

        $params = $request->get_params();

        return is_array($params) ? $params : [];
    }

    protected static function normalize_event_key(array $payload): ?string
    {
        $raw = '';

        if (!empty($payload['event'])) {
            $raw = strtolower((string) $payload['event']);
        } elseif (!empty($payload['status'])) {
            $raw = strtolower((string) $payload['status']);
        }

        if (empty($raw)) {
            return null;
        }

        $raw = str_replace('subscription.', '', $raw);
        $raw = str_replace('sale.', '', $raw);
        $raw = str_replace('purchase.', '', $raw);

        if (str_contains($raw, '.')) {
            $parts = explode('.', $raw);
            $raw   = end($parts);
        }

        $map = [
            'approved' => 'approved',
            'completed' => 'approved',
            'pending' => 'pending',
            'waiting_payment' => 'pending',
            'delayed' => 'pending',
            'canceled' => 'canceled',
            'cancelled' => 'canceled',
            'chargeback' => 'canceled',
        ];

        return $map[$raw] ?? null;
    }
}

Numera_Hotmart_Webhook_Controller::init();

