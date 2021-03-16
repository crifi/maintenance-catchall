Maintenance catchall page
=========================

This project catches all incoming HTTP requests and shows a maintenance page. The maintenance message can be controlled
by JSON files in a directory.

# Installation

1. Install composer on your server.
2. Clone the project.
3. Run the install.sh script from the project root directory.
4. Point you webserver into the public directory
   and [follow the manual of symfony](https://symfony.com/doc/current/setup/web_server_configuration.html) to configure
   it.

# Control maintenance messages

Place one or more JSON files under var/maintenance directory. The content of the JSON files should be an array of
maintenance objects:

```
[
  {
    "host": "/domain.example.com/",
    "title":"Maintenance under domain.example.com",
    "httpStatuscode":503,
    "text": "<p>This page is currently under maintenance</p>"
  },
  {
    "host": "/sub[0-9]{2}.example.com/",
    "title":"Subpage maintenance",
    "httpStatuscode":503,
    "text": "<p>This is a subpage under maintenance.</p>"
  }
]
```

- The hosts value is a regular expression matching the domain name. Do not remove the slashes at the beginning and the
  end of the value since it is the delimiter for the PHP preg_match function.
- In the text value you can use HTML code.

# Set own design

You can place some css files under public/css and some images under public/img. You can also adapt the HTML code by
overwriting some blocks of the templates/my.html.twig:

```
{% extends 'base.html.twig' %}

{% block title %}My own maintenance page title{% endblock %}

{% block footer %}My own footer text {% endblock %}
```