<?php

if (!defined('ABSPATH')) {
    exit;
}

class Numera_Hotmart_Client_Sync
{
    public static function handle_event(string $event_key, array $payload, array $settings): WP_REST_Response|WP_Error
    {
        $email = strtolower(trim(self::extract_value($payload, ['buyer', 'email'], '')));

        if (empty($email) || !is_email($email)) {
            return new WP_Error('hotmart_missing_email', __('Não foi possível identificar o e-mail do comprador.', 'numera_theme'), ['status' => 422]);
        }

        $role = $settings['default_role'] ?: 'subscriber';

        switch ($event_key) {
            case 'approved':
                $user_id = self::handle_purchase_approved($email, $payload, $role);
                break;
            case 'pending':
                $user_id = self::handle_payment_pending($email, $payload);
                break;
            case 'canceled':
                $user_id = self::handle_subscription_canceled($email, $payload);
                break;
            default:
                return new WP_Error('hotmart_unknown_event', __('Evento não suportado.', 'numera_theme'), ['status' => 202]);
        }

        if (is_wp_error($user_id)) {
            return $user_id;
        }

        return new WP_REST_Response(
            [
                'user_id' => $user_id,
                'status'  => $event_key,
            ],
            200
        );
    }

    protected static function handle_purchase_approved(string $email, array $payload, string $role)
    {
        $user_id = self::ensure_user($email, $payload);

        if (is_wp_error($user_id)) {
            return $user_id;
        }

        $user = get_user_by('id', $user_id);

        if ($user instanceof WP_User) {
            $user->set_role($role);
        }

        update_user_meta($user_id, 'hotmart_status', 'approved');
        update_user_meta($user_id, 'hotmart_last_payload', self::prepare_payload_meta($payload));

        return $user_id;
    }

    protected static function handle_payment_pending(string $email, array $payload)
    {
        $user_id = self::ensure_user($email, $payload);

        if (is_wp_error($user_id)) {
            return $user_id;
        }

        update_user_meta($user_id, 'hotmart_status', 'pending');
        update_user_meta($user_id, 'hotmart_last_payload', self::prepare_payload_meta($payload));

        return $user_id;
    }

    protected static function handle_subscription_canceled(string $email, array $payload)
    {
        $user = get_user_by('email', $email);

        if ($user instanceof WP_User) {
            $user->set_role('blocked_user');
            $user_id = $user->ID;
        } else {
            $user_id = self::ensure_user($email, $payload);
            if (is_wp_error($user_id)) {
                return $user_id;
            }
            $user = get_user_by('id', $user_id);
            if ($user instanceof WP_User) {
                $user->set_role('blocked_user');
            }
        }

        update_user_meta($user_id, 'hotmart_status', 'canceled');
        update_user_meta($user_id, 'hotmart_last_payload', self::prepare_payload_meta($payload));

        return $user_id;
    }

    protected static function ensure_user(string $email, array $payload)
    {
        $user = get_user_by('email', $email);

        if ($user instanceof WP_User) {
            return $user->ID;
        }

        $name  = trim(self::extract_value($payload, ['buyer', 'name'], ''));
        $login = self::generate_username($email);
        $pass  = wp_generate_password(16, true);

        $user_id = wp_insert_user(
            [
                'user_login' => $login,
                'user_pass'  => $pass,
                'user_email' => $email,
                'display_name' => $name ?: $email,
                'first_name' => $name,
            ]
        );

        if (is_wp_error($user_id)) {
            error_log('Hotmart integration: erro ao criar usuário - ' . wp_json_encode($user_id->get_error_message()));
            return $user_id;
        }

        update_user_meta($user_id, 'hotmart_generated_password', $pass);

        return $user_id;
    }

    protected static function generate_username(string $email): string
    {
        $base = sanitize_user(current(explode('@', $email)));

        if (empty($base)) {
            $base = 'hotmart_user';
        }

        $login = $base;
        $i     = 1;

        while (username_exists($login)) {
            $login = $base . '_' . $i;
            $i++;
        }

        return $login;
    }

    protected static function extract_value(array $array, array $path, $default = null)
    {
        $value = $array;
        foreach ($path as $segment) {
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    protected static function prepare_payload_meta(array $payload): string
    {
        return wp_json_encode(
            $payload,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}

