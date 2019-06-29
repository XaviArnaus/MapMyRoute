# MapMyRoute
Register coordinates and show them in a Google Maps.

# Benefifs
This simple project brings the following:

- Major part of the features are set up in a json config.
- Light and Dark theme.
- Timezone quick management.
- Using Google Maps Javascript API to represent Marks and Lines.
- Logs visitors. Get parameter to identify origin.
- Mark icon configurable by origin of the visitor.
- IP of the visitor goelocalized.
- Mark printing is ignored if name is omited.
- Autocreates files when needed.
- Basic .htaccess security
- Current **coordinates** gathered via JS / Browse location

# Tech details
Simple Web script using:
- PHP
- HTML
- CSS
- JS

Pluses:
- No MySQL. Storage is Disk. JSON based.
- Main Config file.

# Warnings

- Main blocker is Google Maps. You need a Google Maps API key. Get one [here](https://developers.google.com/maps/documentation/embed/get-api-key)
- Location gathering via JS requires HTTPS. Locally works good.

# Install

Assuming you have an apache virtual host prepared. Let's say `https://localhost`

1. Go to the root of the virtual host
1. Clone the repo there 
    ```
    $ git clone git@github.com:XaviArnaus/kiss-apache-php.git .
    ``` 
1. Create a config file based on the example
    ```
    $ cp config.json.example config.json
    ```
1. Edit the file and set the parameters.
    - Set the Google Maps API key
    - Set the `current_event_example`: A name shown as a title and part of the file name
    - Choose between a `light` or `dark` theme
1. Visit the root of your virtual host in the browser.
    ```
    https://localhost
    ``` 

# Usage
## Display Markers and Route line
- Visit ```https://localhost```
## Add a new point
- Visit ```https://localhost/new.php```
- Accept the browse location
- Submit the form
## Display visitors
- Visit ```https://localhost/visitors.php```
## Identify visitors
To identify visitors, use a querystring parameter ```origin``` with a value defined in the config.
1. Edit `config.json`
1. Check de parameter `visitors_origin`, containing a `key` / `value` object, where:
    1. `key` is the value of the querystring parameter.
    1. `value` is the icon that will be displayed for this origin.
    1. When no defined `origin` parameter in the querystring, `default` will be used internally.
    1. Origins not defined here will be discarded and `default` will be used.
1. Share the link including the parameter, for example:
    1. Basic: ```https://localhost```
    1. In social media ```https://localhost?origin=social```
    1. From a profile page ```https://localhost?origin=profile```
    1. In a QR code ```https://localhost?origin=qr```
## Define your own Marker icons
1. Check the link below to get the list of Google icons.
1. Copy the URL of the icon that you wish
1. Edit `config.json`
1. Replace the URL of the desired `visitors_origin` entry.

# Notes

- Works great testing using a quick docker like my [KISS apache PHP](https://github.com/XaviArnaus/kiss-apache-php)
- [List of icons by Google ready to use](https://sites.google.com/site/gmapsdevelopment/)
    
