<?php

namespace App\Http\Transformers;


class PlaylistTransformer extends Transformer
{
    public function transform($data)
    {
        return [
            'name' => $data['playlist']['name'],
            'datetime_created' => $data['playlist']['datetime_created'],
            'tracks' => [
                $this->attributes('title',  $data['tracks'], $data['artist'])
            ]
        ];
    }

    public function attributes($attributes, $data, $relationship, $fieldName = null)
    {
        if ($fieldName === null) {
            $fieldName = $attributes;
        }

        $array = [];
        foreach ($data as $value) {
            $array[] = [
                $attributes => $value[$fieldName],
                'artist' => $this->relationships($value['id'], $relationship)
            ];
        }

        return $array;
    }

    public function relationships($relationshipId, $data)
    {
        $array = [];
        foreach ($data[$relationshipId] as $value) {
            $array[] = $value['name'];
        }

        return $array;
    }
}