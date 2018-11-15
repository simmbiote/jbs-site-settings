const wpPot = require('wp-pot');

wpPot({
    destFile: './languages/jbs-site-settings.pot',
    domain: 'sim-settings',
    package: 'sim-settings',
    src: './**/*.php'
});
