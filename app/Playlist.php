<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 * @property mixed $get_track
 * @property int $id
 */
class Playlist extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'playlists';

    /**
    * @var bool
    */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'datetime_created'];

    /**
     * @property mixed $get_track
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTrack()
    {
        return $this->belongsToMany('App\Track', 'playlist_tracks');
    }

    public function newPlaylist($data) {
        $track = new track();
        $playlistID = $this->create($data['playlist'])->id;
        $track->createTrack($playlistID, $data['tracks']);
    }

    public static function createPlaylistTracks($playlistID, $trackID)
    {
        return DB::table('playlist_tracks')->insert([
            'playlist_id' => $playlistID,
            'track_id' => $trackID
        ]);
    }
}
