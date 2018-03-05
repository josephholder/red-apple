<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property mixed $get_artists
 * @property mixed $get_playlists
 */
class Track extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tracks';

    public $timestamps = false;

    protected $fillable = ['title'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPlaylists()
    {
        return $this->belongsToMany('App\Playlist', 'playlist_tracks');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getArtists()
    {
        return $this->belongsToMany('App\Artist', 'track_artists');
    }

    public static function createTrackArtists($trackID, $artistID)
    {
        return DB::table('track_artists')->insert([
            'track_id' => $trackID,
            'artist_id' => $artistID
        ]);
    }

    public function createTrack($playlistID, $tracks)
    {
        $artist = new Artist();
        foreach($tracks as $key => $track) {
            $trackID = $this->create(['title' => $track['title']])->id;
            Playlist::createPlaylistTracks($playlistID, $trackID);
            $artist->createArtist($trackID, $track);
        }
    }
}
