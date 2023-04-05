<?php

declare(strict_types=1);

namespace App\Helpers\Response;

class Response
{
    public const OK = 200;
    public const NOTFOUND = 404;
    public const UNPROCESSABLE_ENTITY = 422;
    public const BAD_REQUEST = 400;
    public const METHOD_NOT_ALLOWED = 405;
    public const FATAL_ERROR = 500;

    private ?string $content;
    private int $code;

    public static function make(): self
    {
        return new self();
    }

    public function __construct()
    {
        $this->code = self::OK;
        $this->content = null;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    public function send(): void
    {
        $this->applyHeader();
        $this->applyContent();
        die;
    }

    public function changeCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function changeContent($content): self
    {
        if(is_string($content)) {
            $this->content = $content;
        } else {
            $this->content = json_encode($content);
        }

        return $this;
    }

    private function applyHeader(): void
    {
        header("HTTP/1.1 {$this->code}");
        header('Content-Type:application/json');
        http_response_code($this->code);
    }

    private function applyContent(): void
    {
        if ($this->content) {
            echo $this->content;
        }
    }
}
