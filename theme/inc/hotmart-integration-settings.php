<?php

if (!defined('ABSPATH')) {
    exit;
}

class Numera_Hotmart_Settings
{
    const OPTION_NAME  = 'numera_hotmart_settings';
    const OPTION_GROUP = 'numera_hotmart_options_group';

    public static function init(): void
    {
        add_action('admin_init', [self::class, 'register_settings']);
        add_action('admin_menu', [self::class, 'register_settings_page']);
    }

    public static function get_settings(): array
    {
        $defaults = [
            'enabled'      => false,
            'secret'       => '',
            'default_role' => 'subscriber',
        ];

        $options = get_option(self::OPTION_NAME, []);

        if (!is_array($options)) {
            $options = [];
        }

        return wp_parse_args($options, $defaults);
    }

    public static function get_webhook_url(): string
    {
        return rest_url('numera/v1/hotmart-webhook');
    }

    public static function register_settings(): void
    {
        register_setting(
            self::OPTION_GROUP,
            self::OPTION_NAME,
            [
                'sanitize_callback' => [self::class, 'sanitize_settings'],
            ]
        );
    }

    public static function sanitize_settings(array $input): array
    {
        return [
            'enabled'      => !empty($input['enabled']),
            'secret'       => isset($input['secret']) ? sanitize_text_field($input['secret']) : '',
            'default_role' => isset($input['default_role']) ? sanitize_text_field($input['default_role']) : 'subscriber',
        ];
    }

    public static function register_settings_page(): void
    {
        add_menu_page(
            __('Integração Hotmart', 'numera_theme'),
            __('Hotmart', 'numera_theme'),
            'manage_options',
            'numera-hotmart-settings',
            [self::class, 'render_settings_page'],
            'dashicons-admin-links',
            25
        );
    }

    public static function render_settings_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings    = self::get_settings();
        $roles       = wp_roles()->get_names();
        $webhook_url = self::get_webhook_url();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Integração direta com Hotmart', 'numera_theme'); ?></h1>
            <p><?php esc_html_e('Configure abaixo o token e o papel padrão aplicado aos clientes provenientes da Hotmart.', 'numera_theme'); ?></p>

            <table class="widefat striped" style="margin: 20px 0;">
                <tbody>
                <tr>
                    <th scope="row"><?php esc_html_e('URL do Webhook', 'numera_theme'); ?></th>
                    <td>
                        <code><?php echo esc_html($webhook_url); ?></code>
                        <p class="description"><?php esc_html_e('Use esta URL nas notificações da Hotmart. É necessário enviar o cabeçalho X-Hotmart-Hottok com o token configurado abaixo.', 'numera_theme'); ?></p>
                    </td>
                </tr>
                </tbody>
            </table>

            <form method="post" action="options.php">
                <?php
                settings_fields(self::OPTION_GROUP);
                ?>
                <table class="form-table" role="presentation">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label for="numera-hotmart-enabled"><?php esc_html_e('Ativar integração', 'numera_theme'); ?></label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox"
                                       id="numera-hotmart-enabled"
                                       name="<?php echo esc_attr(self::OPTION_NAME); ?>[enabled]"
                                       value="1"
                                    <?php checked($settings['enabled']); ?>
                                />
                                <?php esc_html_e('Processar eventos enviados pela Hotmart diretamente no WordPress.', 'numera_theme'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="numera-hotmart-secret"><?php esc_html_e('Token (HOTTOK)', 'numera_theme'); ?></label>
                        </th>
                        <td>
                            <input type="text"
                                   id="numera-hotmart-secret"
                                   class="regular-text"
                                   name="<?php echo esc_attr(self::OPTION_NAME); ?>[secret]"
                                   value="<?php echo esc_attr($settings['secret']); ?>"
                                   autocomplete="off"
                            />
                            <p class="description">
                                <?php esc_html_e('Copie o mesmo token configurado no painel da Hotmart. Ele será validado contra o cabeçalho X-Hotmart-Hottok em cada requisição.', 'numera_theme'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="numera-hotmart-default-role"><?php esc_html_e('Papel padrão para clientes', 'numera_theme'); ?></label>
                        </th>
                        <td>
                            <select id="numera-hotmart-default-role"
                                    name="<?php echo esc_attr(self::OPTION_NAME); ?>[default_role]">
                                <?php foreach ($roles as $role_slug => $role_label) : ?>
                                    <option value="<?php echo esc_attr($role_slug); ?>" <?php selected($settings['default_role'], $role_slug); ?>>
                                        <?php echo esc_html($role_label); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php esc_html_e('Usuários aprovados receberão este papel automaticamente.', 'numera_theme'); ?></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}

Numera_Hotmart_Settings::init();

