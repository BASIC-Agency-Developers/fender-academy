module.exports = function(grunt) {
	//require('time-grunt')(grunt);

	// 1. All configuration goes here
	grunt.initConfig({
		config: {
			host: 'fender.dev',
			src: 'src',
			dest: 'public'
		},
		pkg: grunt.file.readJSON('package.json'),
		bower: {
			dev: {
				dest: '<%= config.src %>/assets',
				js_dest: '<%= config.src %>/assets/js/lib',
				css_dest: '<%= config.src %>/assets/css'
			}
		},
		// ngAnnotate: {
		// 	options: {
		// 		singleQuotes: true
		// 	},
		// 	app: {
		// 		files: {
		// 			'<%= config.src %>/assets/js/app.js': ['<%= config.src %>/assets/js/app/app.js'],
		// 			'<%= config.src %>/assets/js/app/**/*.js': ['<%= config.src %>/assets/js/app/**/*.js']
		// 		}
		// 	}
		// },
		concat: {
			dist: {
				src: [
					'<%= config.src %>/assets/js/libs/*.js',
					'!**/*.min.js',
					'!<%= config.src %>/assets/js/libs/jquery.js',
					'!<%= config.src %>/assets/js/libs/modernizr.js',
					'!<%= config.src %>/assets/js/libs/respond.js',
					'!<%= config.src %>/assets/js/libs/selectivizr.js'
				],
				dest: '<%= config.src %>/assets/js/plugins.js',
			}
		},
		sass: {
			dist: {
				options: {
					outputStyle: 'compressed',
					includePaths: require('node-bourbon').includePaths
				},
				files: {
					'<%= config.src %>/assets/css/screen.css': '<%= config.src %>/assets/scss/screen.scss'
				}
			}
		},
		uglify: {
			build: {
				files: [{
					expand: true,
					preserveComments: 'some',
					cwd: '<%= config.src %>/assets/js',
					src: [
						'*.js',
						'!**/*.min.js',
						'libs/jquery.js',
						'libs/modernizr.js',
						'libs/respond.js',
						'libs/selectivizr.js',
						'app/*.js',
						'!app/*.min.js'
					],
					dest: '<%= config.src %>/assets/js',
					ext: '.min.js'
				}]
			}
		},
		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					cwd: '<%= config.src %>/assets/img/',
					src: ['**/*.{png,jpg,gif}'],
					dest: '<%= config.src %>/assets/img/'
				}]
			}
		},
		copy: {
			main: {
				files: [
					/* This moves the assets to server */
					{
						cwd: '<%= config.src %>/',
						src: [
							'assets/**',
							'!assets/scss/**',
							'assets/js/app/*.min.js',
							'assets/js/app/**/*.js',
							'!assets/js/basic/**',
							'assets/js/basic/*.min.js',
							'!assets/js/libs/**',
							'assets/js/libs/*.min.js'
						],
						dest: '<%= config.dest %>/',
						expand: true,
						filter: 'isFile'
					}
				]
			}
		},
		output_twig: {
			dev: {
				options: {
					docroot: '<%= config.src %>',
					tmpext: '.twig',
					context: {
						assets: '/assets'
					}
				},
				files: [
					{
						expand: true,
						cwd: '<%= config.src %>',
						src: ['**/*.twig','!layouts/*.twig','!partials/*.twig'],
						dest: '<%= config.dest %>',
						ext: '.html'
					}
				]
			}
		},
		notify_hooks: {
			options: {
				enabled: true,
				max_jshint_notifications: 1,
				success: true,
				duration: 1
			}
		},
		notify: {
			watch: {
				options: {
					title: '<%= config.host %>',
					message: 'Grunt tasks completed'
				}
			},
			sass: {
				options: {
					title: '<%= config.host %>',
					message: 'SCSS files compiled'
				}
			},
			js: {
				options: {
					title: '<%= config.host %>',
					message: 'JS files compiled'
				}
			},
			output_twig: {
				options: {
					title: '<%= config.host %>',
					message: 'Twig files compiled'
				}
			},
			files: {
				options: {
					title: '<%= config.host %>',
					message: 'Files copied'
				}
			}
		},
		watch: {
			gruntfile: {
				files: 'Gruntfile.js',
				tasks: ['concat','sass','uglify','newer:copy','notify:watch','watch'],
			},
			files: {
				files: ['<%= config.src %>/assets/img/**/*.{png,gif,jpg,svg}'],
				tasks: ['newer:copy','notify:files'],
				options: {
					spawn: false,
				},
			},
			templates: {
				options: {
					spawn: true,
					cwd: '<%= config.src %>'
				},
				files: ['**/*.twig'],
				tasks: ['output_twig:dev']
			},
			scripts: {
				files: ['<%= config.src %>/assets/js/**/*.js','!<%= config.src %>/assets/js/**/*.min.js'],
				tasks: ['concat','uglify','newer:copy','notify:js'],
				options: {
					spawn: false,
				},
			},
			css: {
				files: [
					'<%= config.src %>/assets/scss/*.scss',
					'<%= config.src %>/assets/scss/**/*.scss'
				],
				tasks: ['sass','newer:copy','notify:sass'],
				options: {
					spawn: false,
				}
			}
		}

	});

	// 3. Load Grunt Tasks
	require('load-grunt-tasks')(grunt, {
		pattern: ['*', '!load-grunt-tasks', '!node-bourbon']
	});

	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-annotate');

	// 4. Where we tell Grunt what to do when we type 'grunt' into the terminal.
	grunt.registerTask('default', [
		'ngAnnotate',
		'concat',
		'sass',
		'imagemin',
		'uglify',
		'newer:copy',
		'output_twig',
		'watch'
	]);

	grunt.registerTask('build', [
		'bower',
		'ngAnnotate',
		'concat',
		'sass',
		'imagemin',
		'uglify',
		'copy',
		'output_twig'
	]);

	grunt.registerTask('minify', ['uglify']);
	grunt.registerTask('images', ['imagemin']);
	grunt.registerTask('make', ['output_twig']);
	grunt.registerTask('move', ['copy']);
};
