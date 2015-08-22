# Grunwell WordPress Starter Theme

This project contains the basic foundation I use when creating new WordPress themes. It's not really meant to be used by itself but rather start as a base for building new custom themes. What I've given you should be flexible, organized, and ready for whatever you want to throw at it.

This theme starter makes a few assumptions based on my typical workflow; if yours is different, please feel free to modify this as you see fit. The assumptions are:

1. The theme will be responsive
2. Stylesheets will be written in Sass (using Compass)

## Features

* HTML5 markup with ARIA Landmark roles
* CSS reset with baseline typography and utility classes
* Localization-ready
* Pre-configured for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

## Usage

Download/clone the repository into wp-content/themes/. From there, start building!

You may want to start with the following:

### Setup theme information

There are a number of variables throughout the theme files that are meant to be swapped out (find+replace, sed, etc.) with the appropriate information.:

* **%Author%** - Your name or your company's name
* **%Text_Domain%** - The theme's text domain (used for i18n)
* **%Theme_Name%** - The name of the theme
* **themename_** - Prefix on all theme-specific functions
* **wordpress-starter-theme** - Name of the theme directory (i.e. /wp-content/themes/wordpress-starter-theme)

You may also want to include a theme screenshot.png, which should be 880x660px.

### Grunt.js

The theme is configured to use [Grunt.js](http://gruntjs.com/) to handle build tasks like compiling stylesheets, concatenating and minifying JavaScript, and running scripts through JSHint. Once everything's configured to your liking run `npm install` to download the node packages into the theme; once those packages are installed running the build process is as simple as `grunt` (or `grunt watch` if you don't want to run it each time).

#### Stylesheets

The theme styles are written using [Compass](http://compass-style.org), a [Sass CSS pre-processor](http://sass-lang.com/) framework. The idea behind this is to have reusable, well-organized stylesheets in `assets/sass` but our theme serves concatenated and compressed styles from `assets/css`.

Your Compass configuration is in config.rb.

#### JavaScript

The general idea is that scripts in js/ are those ready to be served (post-concatenation and minification), while js/src/ contains the files that get minified, while js/src/lib/ contains third-party scripts that you might include in your bundled files.

For example, let's say we're using [WooTheme's Flexslider](http://www.woothemes.com/flexslider/) for a hero carousel that only appears on the homepage. Rather than load this content on _every_ page, we'll load a file on the homepage template that contains the Flexslider plugin along with our custom scripting for Flexslider.

Our directory structure might look something like this:

```
assets/js/hero-carousel.js (the file we'll serve to browsers)
assets/js/src/hero-carousel-scripting.js (our custom scripting for the carousel)
assets/js/src/lib/jquery.flexslider.js (the Flexslider plugin)
```

Then, in our Gruntfile.js, we'd add the following to our `concat` and `uglify` configurations:

```diff
	concat: {
		dist: {
			src: ['assets/js/src/theme.js'],
			dest: 'assets/js/scripts.js'
+   },
+   heroCarousel: {
+     src: ['assets/js/src/lib/jquery.flexslider.js', js/src/hero-carousel-scripting.js'],
+     dest: 'assets/js/hero-carousel.js'
		}
	},

	uglify: {
		min: {
			files: {
-       'assets/js/scripts.js': ['assets/js/scripts.js']
+       'assets/js/scripts.js': ['assets/js/scripts.js'],
+       'assets/js/hero-carousel.js': ['assets/js/hero-carousel.js']
			}
		}
	},
```

##### Resources

* [An Introduction to Sass in Responsive Design](http://stevegrunwell.com/blog/intro-to-sass-in-responsive-design)
* [Recompile Sass Upon Deployment Using Git Hooks](https://stevegrunwell.com/blog/automatically-recompile-sass-upon-deployment-using-git-hooks/)


### PHP_CodeSniffer

The starter theme comes with [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) as a development dependency. PHP_CodeSniffer will check your code against the [WordPress-Extra and WordPress-Docs coding standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards#standards-subsets) to ensure you're writing high-quality WordPress code.

To check your code against these standards, install the composer dependencies (`composer install`) and run the following:

```bash
$ ./vendor/bin/phpcs
```

If you'd like to alter the sniffs used, you can edit phpcs.xml, which follows the [PHP_CodeSniffer ruleset.xml format](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Annotated-ruleset.xml).


### Delete this file

Once you're on your way to building the next awesome theme you probably don't need these setup instructions. You can keep the file around if you want but there's zero need or obligation for you to do so.

## Site plugins

If you plan to use features like custom post types, taxonomies, etc. I encourage you to check out [this starter theme's sibling project](https://github.com/stevegrunwell/wordpress-starter-plugin), a similar starter plugin. By isolating things like custom post types into a plugin you reduce the risk of data being lost when you change themes in the future. It's a good habit to get into and the starter plugin makes it a cinch to get started.

## Support this project

This starter kit is free for anyone to use but it is tailored towards my ever-changing personal workflow. If there's something you don't like about it please feel free to fork the project and create your own personal starter kit. I likely will not be accepting pull requests unless a) there's a bug or b) you introduce me to a feature so totally cool that I immediately adopt it as a default in my theme development workflow.

## License

This theme starter is dual-licensed under both the [Don't Be a Dick](http://www.dbad-license.org/) and [WTF](http://www.wtfpl.net/) Public Licenses, which are GPLv2, MIT, and pretty much every-other-license-ever compatible.

Please have fun and build something awesome!