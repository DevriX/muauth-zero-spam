# Zero Spam Multisite Auth Integration

Spamming can be a headache when it comes to sites that ship with front-end public forms such as for memberships. Eliminating spam can be done in many different ways, involving human test captchas, tests, firewall checks etc but sometimes keeping things simple is worth it; automated programs (spammers, bots, scripts, etc) work on platforms that don't have JavaScript run by default, and <a href="https://github.com/bmarshall511/wordpress-zero-spam/">Zero Spam</a> will basically append a verification key to Multisite Auth signup forms with JS, to use to check whether we're serving a hooman or a bot.

Both <a href="https://github.com/bmarshall511/wordpress-zero-spam/">Zero Spam</a> and <a href="https://github.com/elhardoum/multisite-auth/">Multisite Auth</a> plugins are required.

You can activate both mentioned plugins only on your authentication site, they're not required in other sites or the main site.

## Use

Usage is very simple, basically just make sure this plugin is active on the auth blog (or activate it for the whole network to make sure) and it will do the job.
