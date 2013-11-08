
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Commons In A Box %s', 'cbox' ), cbox_get_version() ); ?></h1>

			<div class="about-text" style="min-height:90px;"><?php printf( __( 'Thank you for updating to the latest version!', 'cbox' ), cbox_get_version() ); ?></div>

			<div class="wp-badge"><?php printf( __( 'Version %s' ), cbox_get_version() ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a href="<?php echo self_admin_url( 'admin.php?page=cbox&whatsnew=1' ); ?>" class="nav-tab nav-tab-active">
					<?php _e( 'What&#8217;s New', 'cbox' ); ?>
				</a>
				<a href="<?php echo self_admin_url( 'admin.php?page=cbox&credits=1' ); ?>" class="nav-tab">
					<?php _e( 'Credits', 'cbox' ); ?>
				</a>
			</h2>

			<div class="changelog">
				<h3><?php _e( '1.0.6 Maintenance Release', 'cbox' ); ?></h3>
				<p><?php _e( 'The 1.0.6 release brings a number of plugins up to date, and improves compatibility with WordPress 3.7+.', 'cbox' ) ?></p>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Plugin Updates', 'cbox' ); ?></h3>

				<div class="feature-section">
					<h4><?php _e( 'Since the last version release, the following plugins were updated in CBOX:', 'cbox' ); ?></h4>
					<ul>
						<li>bbPress 2.4.1</li>
						<li>BuddyPress Docs 1.5.5</li>
						<li>BuddyPress Docs Wiki 1.0.5</li>
						<li>Invite Anyone 1.0.25</li>
					</ul>

				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Theme Improvements', 'cbox' ); ?></h3>

				<div class="feature-section">
					<h4><?php _e( 'Since the last version release, the following bugfixes and enhancements were added to the Commons In A Box theme:', 'cbox' ); ?></h4>
					<ul>
						<li>A brand new slider that is easier to use and performs better on different devices</li>
						<li>Improved appearance of Docs attachment lists in directories and on single Doc pages</li>
						<li>Fix some debug notices</li>
					</ul>

				</div>
			</div>

			<?php /*
			<div class="changelog">
				<h3><?php _e( 'Under the Hood', 'cbox' ); ?></h3>

				<div class="feature-section col two-col">
					<div>

						<p><strong>New CBOX option:</strong> For BuddyPress group pages, you can now set the default tab to "Forum".  Try this feature by selecting it on the "Commons In A Box > Settings" page.</p>

					</div>

					<div class="last-feature">

						<p><strong>bbPress Editor is Back!</strong> The visual editor in bbPress was disabled as of v2.3, however CBOX users can rejoice as it is automatically enabled on your site.</p>

					</div>
				</div>

				<div class="feature-section col two-col">
					<div>
						<p><strong>Bug fix:</strong> Fixed bug in Custom Profile Filters for BuddyPress that caused some social networking fields to render incorrectly.</p>
					</div>
				</div>

			</div>
			*/ ?>

			<div class="return-to-dashboard">
				<?php printf( __( '<a href="%s">Return to the CBOX dashboard &rarr;</a>', 'cbox' ), self_admin_url( 'admin.php?page=cbox' ) ); ?>
			</div>

		</div>
