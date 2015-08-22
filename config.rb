# Require any additional Compass plugins here.

# Set this to the root of your project when deployed:
http_path = '/wp-content/themes/wordpress-starter-theme/'
css_dir = 'assets/css'
sass_dir = 'assets/sass'
images_dir = 'img'
#generated_images_dir = 'assets/img/generated'
javascripts_dir = 'js'
#fonts_dir = 'assets/fonts'

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false

##
# Don't apply a cache-buster to generated assets
# @link http://stackoverflow.com/a/9332472/329911
asset_cache_buster :none

on_sprite_saved do |filename|
	if File.exists?(filename)
		FileUtils.mv filename, filename.gsub(%r{-s[a-z0-9]{10}\.png$}, '.png')
	end
end

# Replace in stylesheets generated references to sprites
# by their counterparts without the hash uniqueness.
on_stylesheet_saved do |filename|
	if File.exists?(filename)
		css = File.read filename
		File.open(filename, 'w+') do |f|
			f << css.gsub(%r{-s[a-z0-9]{10}\.png}, '.png')
		end
	end
end