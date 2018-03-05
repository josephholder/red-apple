# Red-apple

Language: PHP  
Framework: Laravel 5.6  
Packages: laravel-ide-helper

Have built a laravel application according to the test. The application can store, show, delete a playlist as per the request.

The url to store a playlist: /api/v1/playlist  

Below is a json object that can respond with the api, the relationships are many tracks to one playlist and many artists to one track.  
{ "name": "name", "tracks": [ { "title": "title 1", "artists": [ "artist 1", "artist 2" ] } ] }

The url to show a playlist: /api/v1/playlist/{id:}  

The show response requires the id of the playlist in the url. The response is a json object with the playlist relationships.


The url to delete a playlist: /api/v1/playlist/{id:}  

The delete request requires the id of the playlist in the url. This will remove the playlist and its relationship to tracks and artists

Validation:  

If a route is not found returns a status of 400  
If {id:} is not found the response is status 400

When storing the data there are validation rules:  
All playlist information is required|string|unique.    
All track information is required|string.    
All artist information is required|array.  
 