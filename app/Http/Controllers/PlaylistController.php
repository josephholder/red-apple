<?php

namespace App\Http\Controllers;

use App\Track;
use App\Playlist;
use Carbon\Carbon;
use App\Http\Requests\PlaylistFormRequest;
use App\Http\Transformers\PlaylistTransformer;


class PlaylistController extends Controller
{

    /**
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * @param PlaylistFormRequest $request
     * @param Playlist $playlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PlaylistFormRequest $request, Playlist $playlist)
    {
        $data = [
            'playlist' => [
                'name' => $request->input('name'),
                'datetime_created' => Carbon::now()->toDateTimeString()
            ],
            'tracks' => $request->input('tracks')
        ];

        $playlist->newPlaylist($data);

        $response = [
            'message' => 'playlist created',
            'code' => 200,
            'data' => $data
        ];

        return response()->json($response, 200);
    }


    /**
     * @param Playlist $playlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Playlist $playlist)
    {
        $tracks = new Track();
        $tracksData = $playlist->find($playlist->id)->getTrack()->get();

        $artistsData = [];
        foreach ($tracksData as $track) {
            $artistsData[$tracks->find($track->id)->id] = $tracks->find($track->id)->getArtists()->get()->toArray();
        }

        $data = [
            'data' => [
                'playlist' => [
                  'name' => $playlist->name,
                  'datetime_created' => Carbon::parse($playlist->toArray()['datetime_created'])
                      ->diffForHumans()
                ],
                'tracks' => $tracksData->toArray(),
                'artist' => $artistsData
            ]
        ];

        $response = (new PlaylistTransformer())->transformCollection($data);
        return response()->json($response, 200);
    }


    /**
     * @param Playlist $playlist
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Playlist $playlist)
    {
        $tracks = new  Track();

        foreach ($playlist->getTrack()->pluck('tracks.id') as $track){
            $tracks->find($track)->getArtists()->detach();
        }
        $playlist->getTrack()->detach();
        $playlist->delete();

        $data = [
            'message' => 'playlist deleted'
        ];

        return response()->json($data, 200);
    }
}
