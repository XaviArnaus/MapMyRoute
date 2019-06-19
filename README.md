# MapMyRoute
Register coordinates and show them in a Google Maps.

- Current **coordinates** gathered via JS. Very convenient.

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

# Notes

- Works great testing using a quick docker like my [KISS apache PHP](https://github.com/XaviArnaus/kiss-apache-php)
    
