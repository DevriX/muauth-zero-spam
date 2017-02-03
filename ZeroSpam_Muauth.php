<?php
// prevent direct access
defined('ABSPATH') || exit('Direct access not allowed.' . PHP_EOL);

class ZeroSpam_Muauth extends ZeroSpam_Plugin
{
    public function run()
    {
        add_action( 'muauth_validate_registration_early_bail', array( $this, 'muauthSignupValidate' ) );
    }

    public function muauthSignupValidate()
    {
        if ( ! zerospam_is_valid() ) {
            do_action( 'zero_spam_found_spam_muauth_registration' );

            if ( isset( $this->settings['log_spammers'] ) && ( '1' == $this->settings['log_spammers'] ) ) {
                zerospam_log_spam( 'multisite-auth' );
            }

            return wp_die(apply_filters(
                'ZeroSpam_Muauth_message',
                '<h3>Bam!</h3><p>Sorry, but we cannot process your request for the moment.</p>'
            ));
        }
    }
}