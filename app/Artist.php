<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $get_tracks_with_pivot
 * @property mixed $get_tracks
 */
class Artist extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artists';

    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getTracks()
    {
        return $this->belongsToMany('App\Track', 'track_artists');
    }

    public function createArtist($trackID, $track)
    {
        foreach($track['artists'] as $artists) {
            $artistID = $this->create(['name' => $artists])->id;
            Track::createTrackArtists($trackID, $artistID);
        }
    }
}
