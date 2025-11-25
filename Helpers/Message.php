<?php
namespace Helpers;

class Message
{
    public const COLOR_INFO    = 'alert-info';
    public const COLOR_SUCCESS = 'alert-success';
    public const COLOR_ERROR   = 'alert-danger';

    public string $title;
    public string $content;
    public string $color;

    public function __construct(
        string $content,
        string $color = self::COLOR_INFO,
        string $title = 'Information'
    ) {
        $this->title   = $title;
        $this->content = $content;
        $this->color   = $color;
    }
}
