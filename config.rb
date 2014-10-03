# Compass is a great library for Sass! http://compass-style.org/
# It is possible to compile the Sass using a Grunt task, but I think the Compass compiler is slightly faster.

#########
# 1. Root of the project
http_path = "/"

# 2. probably don't need to touch these
css_dir = ""
sass_dir = "assets/scss"
images_dir = "assets/img"
javascripts_dir = "assets/js"
environment = :development
relative_assets = true


# 3. You can select your preferred output style here (can be overridden via the command line):
#output_style = :expanded

# 4. Keeping this to expanded because the WP theme repo doesn't like minified style.css
output_style = :expanded

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false

# don't touch this
preferred_syntax = :scss