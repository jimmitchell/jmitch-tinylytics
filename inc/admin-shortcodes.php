<h2>WP Tinylytics Shortcodes</h2>

<p>WP Tinylytics comes comes with a variety of shortcodes which can be embedded directly in a post, page, or can be used in a theme template file to reduce the need for extensive HTML customizations. More on using in theme files below.</p>
<p>The shortcodes available are:</p>

<table class="form-table" role="presentation" style="font-size:inherit;">
    <tr style="background:#fafafa;border-bottom:1px solid #c3c4c7;"><th style="width:10%;">Shortcode</th><th style="width:30%;">Description</th><th>Example Code Output</th></tr>
    <tr><th>[tinykudos]</th><td>Displays an interactive button to track "kudos" given by readers. Best used directly in posts and pages.</td><td><code>&lt;button class="tinylytics_kudos" data-path="/path/to/page"&gt;&lt;/button&gt;</code></td></tr>
	<tr><th>[tinyhits]</th><td>Displays a count of page loads of the page viewed. Best used directly in posts and pages.</td><td><code>&lt;span class="tinylytics_hits" data-path="/path/to/page"&gt;&lt;/span&gt;</code></td></tr>
	<tr><th>[tinystats]</th><td>Displays both overall site hits and uptime (<em>Note: a Tinylytics subscription is required to display uptime</em>). Best used in the footer of your site.</td><td><code>&lt;p&gt;&lt;span class="tiny_counter"&gt;&lt;a href="https://tinylytics.app"&gt;Tinylytics&lt;/a&gt;: &lt;span class="tinylytics_hits"&gt;&lt;/span&gt;&lt;/span&gt;&lt;span class="tiny_uptime"&gt;Uptime: &lt;span class="tinylytics_uptime"&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;</code></td></tr>
	<tr><th>[tinywebring]</th><td>Displays a random link to a Tinylytics webring site. Enabling the "Display webring avatars?" option will include the avatar if the site has one. Best used in the footer of your site.</td><td><code>&lt;p&gt;&lt;span class="tiny_webring"&gt;&lt;a href="" class="tinylytics_webring"&gt;🕸️&lt;img class="tinylytics_webring_avatar" src="" style="display:none"/&gt;💍&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;</code></td></tr>
	<tr><th>[tinyflags]</th><td>Displays flags from all the countries of site visitors. Best used in the footer of your site.</td><td><code>&lt;p&gt;&lt;span class="tinylytics_countries"&gt;&lt;/span&gt;&lt;/p&gt;</code></td></tr>
</table>

<p>More information can be found in the <a href="https://tinylytics.app/docs" target="_blank">Tinylytics Documentation</a>.

<hr />

<h2>Using Shortcodes in Theme Templates</h2>
<p>If you'd like to more permanently add Tinylytics options to your theme pages or footer, you can easly embed them using the WordPress <code>do_shortcode();</code> function. For example, you you wanted to modify your theme's footer file to add stats (hit and uptime), webring and country flags, you would add the following shortcodes where appropriate in your <code>footer.php</code> theme file:</p>
<pre>
&lt;?php echo do_shortcode( ' [tinystats] ' ); ?&gt;
&lt;?php echo do_shortcode( ' [tinywebring] ' ); ?&gt;
&lt;?php echo do_shortcode( ' [tinyflags] ' ); ?&gt;
</pre>
<p class="notice notice-error settings-error" style="padding:9px;"><span class="warning-message">Please Note:</span> I am not responsible for any data loss or theme errors that result from editing your theme files, nor can I assist you with any edits. You accept all risks that come with editing your theme template files. Before making changes, always backup your theme in a safe place, and <em><strong>never ever</strong></em> edit your code directly in production. You'll thank me later for this.</p>
<hr />

<h2>Styling Shortcodes</h2>
<p>What's the point of using shortcodes if you don't make them look good? The CSS classes below can be used to style the example code above.</p>
<pre>
.tinylytics_kudos {
    /* this class styles the entire Kudos &lt;button&gt; */
}

.did_select {
    /* Styles the Kudos &lt;button&gt; to appear different/inactive once a Kudo is given */
}

.tinylytics_hits {
    /* Styles the hit counter number only */
}

.tiny_counter {
    /* Styles the entire counter &lt;span&gt; */
}

.tiny_uptime {
    /* Styles the uptime &lt;span&gt; */
}

.tiny_webring {
    /* Styles the webring &lt;span&gt; */
}

.tinylytics_webring {
    /* Styles the webring link only */
}

.tinylytics_webring_avatar {
    /* Styles the webring avatar image */
}

.tiny_countries {
    /* Styles the country flags &lt;span&gt; */
}
</pre>