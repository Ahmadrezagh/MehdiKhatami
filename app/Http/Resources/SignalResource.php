<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SignalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'exchange' => [
                'right' => [
                    'name' => $this->exchange->right_flag->name,
                    'src' => url($this->exchange->right_flag->src)
                    ],
                'left' => [
                        'name' => $this->exchange->left_flag->name,
                        'src' => url($this->exchange->left_flag->src)
                    ]
              ],
            'signal_type' => [
                'title' => $this->signal_type->title,
                'color' => $this->signal_type->color
            ],
            'command' => [
                'title' => $this->command->title,
                'color' => $this->command->color
            ],
            'result' => [
                'title' => $this->result->title,
                'color' => $this->result->title
            ]
        ];
    }
}
